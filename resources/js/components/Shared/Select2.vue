<template>    
    <div>
        <select class="select2" :name="name" :disabled="disabled" :required="required"></select>
    </div>
</template>

<script>
    // import 'select2/dist/js/select2.min.js'
    import 'select2/dist/js/select2.full';

    export default {
        name: "Select2",
        //props: ["options", "modelValue", "ajax", "tags"],
        props: {
            modelValue: [String, Array], // previously was `value: String`
            name: {
                type: String,
                default: ''
            },
            placeholder: {
                type: String,
                default: ''
            },
            options: {
                type: Array,
                default: () => []
            },
            disabled: {
                type: Boolean,
                default: false
            },
            required: {
                type: Boolean,
                default: false
            },
            settings: {
                type: Object,
                default: () => {}
            }
        },
        data() {
            return {
                select2: null
            };
        },

        watch: {
            options: {
                handler(val) {
                    this.setOption(val);
                },
                deep: true
            },
            modelValue: {
                handler(val) {
                    this.setValue(val);
                },
                deep: true
            },
        },

        mounted() {
            this.select2 = $(this.$el)
                .find('select')
                .select2({
                    //dropdownParent: $(this.$refs.rootSelect),
                    placeholder: this.placeholder,
                    ...this.settings,
                    data: this.options
                })
                .on('select2:select select2:unselect', ev => {
                    this.$emit('update:modelValue', this.select2.val());
                    //this.$emit('select', ev['params']['data']);
                });
            this.setValue(this.modelValue);
        },

        methods: {
            setOption(val = []) {
                this.select2.empty();
                this.select2.select2({
                    placeholder: this.placeholder,
                    ...this.settings,
                    data: val
                });
                this.setValue(this.modelValue);
            },
            setValue(val) {
                if (val instanceof Array) {
                    this.select2.val([...val]);
                } else {
                    this.select2.val([val]);
                }
                this.select2.trigger('change');
            }
        },

        beforeUnmount() {
            this.select2.select2('destroy');
        }

        // mounted() {
        //     let self = this
        //     let options = [];
        //     options.push({
        //         id: "",
        //         text: "Choose...", // Supports vue-i18n, just put 'this.$t('select2.choose')' here 
        //         disabled: true,
        //         selected: true
        //     });
        //     options = options.concat(this.options);
            
        //     console.log(self.value, this.$el)
                    
        //     $(this.$el)
        //         // init select2
        //         .select2({ ajax: this.ajax, tags: this.tags, data: options })
        //         .val(this.value)
        //         .trigger("change")
        //         // emit event on change.
        //         .on("change", function(e) {
        //             self.$emit('input', e.target.value);
        //         });
        // },
        // watch: {
        //     value(value) {
        //         // update value
        //         console.log(value)
        //         $(this.$el)
        //             .val(value)
        //             .trigger("change");

        //         // if(!$(this.$el).val()) {
        //         //     return
        //         // }
        //         // //$(this.$el).val(value).trigger('change')
        //         // // update value
        //         // if ([...value].sort().join(",") !== [...$(this.$el).val()].sort().join(","))
        //         //     $(this.$el).val(value).trigger('change')
        //     },
        //     options(newoptions) {
        //         let options = [];
        //         options.push({
        //             id: "",
        //             text: "Choose...", // Supports vue-i18n, just put 'this.$t('select2.choose')' here 
        //             disabled: true,
        //             selected: true
        //         });
        //         options = options.concat(newoptions);
        //         $(this.$el)
        //             .empty()
        //             .select2({ data: options });
        //         //$(this.$el).empty().select2({ data: options })
        //         //$(this.$el).select2({ data: options })
        //     }
        // },
        // destroyed() {
        //     $(this.$el).off().select2('destroy')
        // }
    }
</script>