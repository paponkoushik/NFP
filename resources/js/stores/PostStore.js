import useDatatableFunc from "@/composables/useDatatableFunc.js";
import {useUrlFunc} from '@/composables/useUrlFunc.js';
import useUtilsFunc from '@/composables/useUtilsFunc.js';
import {post} from "@/core/endpoints";
import {defineStore} from 'pinia';
import {COMMON_DATA} from "../core/preference_data";

const {destroy} = useUtilsFunc();
const {buildURLQuery} = useUrlFunc();
const {getItemAndMetaData} = useDatatableFunc();

export const usePostStore = defineStore('PostStore', {
    state: () => ({
        meta                      : {},
        posts                     : [],
        locations                 : [],
        offerTypes                : [],
        categories                : [],
        interests                 : [],
        post_author               : null,
        loading                   : false,
        uploadImages              : [],
        images                    : [],
        categoryExcludeFields     : [],
        categoryExcludeFieldValues: {},
        categoryCustomLabels      : {},
        currentPost               : null,
        form                      : {
            id                : null,
            category          : null,
            category_name     : null,
            category_id       : null,
            sub_category      : null,
            sub_child_category: null,
            location_id       : null,
            type              : '',
            preferences       : {
                where: '',
                ...COMMON_DATA
            },
            description       : '',
        },
        postId: null,
        openPostOffersModal: false,
    }),

    getters: {
        totalPost() {
            return this.meta?.total ?? this.posts.length;
        },
    },

    actions: {
        async fill(params) {
            fullPageLoader.show();
            this.loading = true

            if (this.post_author) {
                params = {...params, author: this.post_author};
            }

            const urlParams = buildURLQuery(params, true);
            try {
                const result = await axios.get(`${post}/all${urlParams ? `?${urlParams}` : ''}`);
                const {data, meta} = getItemAndMetaData(result.data);
                this.meta = meta;
                this.posts = data;
            } catch (error) {
                const message = error.response?.data?.message ?? error.message;
                flash(message, "danger");
            } finally {
                this.loading = false
            }

            fullPageLoader.hide();
        },

        async submit(formData) {
            // fullPageLoader.show();
            console.log('form data: ', formData);

            // formData = {...formData, ...this.form};
            formData = {...this.form, ...formData};
            formData.images = this.uploadImages;
            console.log('after merge form data: ', formData);

            try {
                const formId = this.form.id;
                /*formData.old_images = this.images;
                formData.new_images = this.uploadImages;
                formData.category_id = formData.sub_category_id ?? formData.category;
                formData.is_anonymous = formData.is_anonymous ? 1 : 0;
                formData.price_type = this.form.price_type;*/

                if (formId) {
                    formData._method = "PUT";
                }
                const url = !formId ? post : `${post}/${formId}`;

                const response = await axios.post(url, formData);
                console.log('response: ', response);
                flash(response.data.message);

                const redirectUrl = formId ? "/our-posts" : "/posts";
                location.replace(redirectUrl);
            } catch (error) {
                if (error.response.status == 422) {
                    const errors = "errors" in error.response.data ? error.response.data.errors : error.response.data;
                    throw errors;
                }

                flash(error.response.data.message, "danger");
            }

            fullPageLoader.hide();
        },

        delete(data) {
            confirm("Do you want to delete this post?").then(isConfirm => {
                if (isConfirm) {
                    fullPageLoader.hide();

                    destroy(`${post}/${data.id}`).then(response => {
                        if (response) {
                            this.posts.splice(this.posts.indexOf(data), 1)
                            fullPageLoader.hide();
                        }
                    });
                }
            });
        },

        fillProps({post, types, locations, interests, categories, excludeFields = [], excludeFieldValues = {}}) {
            this.offerTypes = types;
            this.locations = locations;
            this.categories = categories;
            this.interests = interests;
            this.categoryExcludeFields = excludeFields;
            this.categoryExcludeFieldValues = excludeFieldValues;
            this.currentPost = post;
            this.handlePostEdit(post);
        },

        handlePostEdit(post) {
            if (post?.id) {
                for (let key in this.form) {
                    if (key === 'preferences') {
                        this.form[key] = post[key] || {
                            where: '',
                            ...COMMON_DATA
                        }
                    } else {
                        this.form[key] = post[key];
                    }

                }

                // add slash to the start of the url
                this.images = post?.orginalImages ? post?.originalImages?.map(image => {
                    return '/' + image;
                }) : [];
                this.uploadImages = post?.originalImages ? post?.originalImages : [];
                this.form.old_images = post?.originalImages ? post?.originalImages : [];
                this.form.title = post?.title;
                this.form.type = post?.type;
                this.form.location_id = post?.location_id;
                this.form.address = post?.address;
                this.form.state = post?.state;
                this.form.city = post?.city;
                this.form.postcode = post?.postcode;
                this.form.is_anonymous = post?.is_anonymous;
                this.form.category_name = post?.category?.parent && post?.category?.parent?.parent ? post?.category?.parent?.parent?.name : post?.category?.parent?.name;
                this.form.sub_category = post?.category?.parent && !post?.category?.parent?.parent ? post?.category?.parent?.name : post?.category?.name;
                this.form.sub_child_category = post?.category?.parent && post?.category?.parent?.parent ? post?.category?.name : null;
                this.form.sub_category_id = post.category_id;
                this.form.category = post.category_id;
            }
        },

        openOurPostOffersModal(post_id) {
            this.postId = post_id
            this.openPostOffersModal = true;
        },
        closeOurPostOffersModal() {
            this.postId = null
            this.openPostOffersModal = false;
        }
    }
});
