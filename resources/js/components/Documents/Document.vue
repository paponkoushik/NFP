<script setup>
import { debounce } from "lodash";
import { useDocumentStore } from "@/stores/DocumentStore";
import { useCollectionStore } from "@/stores/CollectionStore";
import DocumentCollection from "@/components/DocumentManagement/DocumentCollection";
import { useUrlFunc } from "../../composables/useUrlFunc";
import { onMounted } from "vue";

const props = defineProps({
  type: {
    type: String,
    default: "document",
  },
});

const store = useDocumentStore();
const collectionStore = useCollectionStore();
const { pushUrlState, getUrlParams } = useUrlFunc();

function pageChange({ page, limit }) {
  if (props.type === "purchase") {
    const params = { page, limit, query: store.search };
    store.getPurchaseDocuments(params);
  } else {
    store.fill({ page, limit });
  }
}

const handleFilter = () => {
  const params = { query: store.search };
  pushUrlState(params);

  if (props.type === "purchase") {
    store.getPurchaseDocuments({
      page: 1,
      limit: 10,
      type: props.type,
      ...params,
    });
  } else {
    collectionStore.fill();
  }
};

const setDefaultUrlParams = () => {
  const urlParams = getUrlParams();
  if (urlParams && Object.keys(urlParams).length) {
    store.search = urlParams.query || "";
  }
};

const handleSearch = debounce(function (e) {
  const currentStr = e.target.value;
  const prevStr = store.search;
  console.log(currentStr, prevStr);

  if (
    (prevStr == "" || currentStr === prevStr) &&
    (currentStr.length < 1 ||
      currentStr === prevStr ||
      currentStr.replace(/\s/g, "") == "")
  ) {
    return;
  }
  store.search = currentStr;

  handleFilter();
}, 500);

onMounted(() => {
  setDefaultUrlParams();
  handleFilter();
});
</script>

<template>
  <div class="row">
    <div class="col-sm-6 col-md-4" v-if="type == 'document'">
      <div
        class="card"
        :class="$setLoadingSpinner(store.loading)"
        style="min-height: 75vh"
      >
        <CardHeader title="Collections"></CardHeader>
        <hr />

        <div
          class="accordion collection-accordion no-arrow pt-2 p-4"
          id="accordionExample"
        >
          <h6 v-if="collectionStore.totalCollection <= 0" class="text-center">
            No document collections found...
          </h6>

          <DocumentCollection
            :level="1"
            :store="store"
            :collections="collectionStore.collections"
          >
          </DocumentCollection>
        </div>
      </div>
    </div>

    <div :class="type == 'document' ? 'col-sm-6 col-md-8' : 'col-12'">
      <div class="card" style="min-height: 75vh">
        <Datatable table-class="less-padding">
          <CardHeader
            :title="type == 'purchase' ? 'Purchase Documents' : 'Documents'"
            class="pb-3"
          >
            <div class="dt-buttons">
              <div class="input-group input-group-merge input-group-sm">
                <span class="input-group-text" id="basic-addon-search31"
                  ><i class="bx bx-search"></i
                ></span>
                <input
                  type="text"
                  class="form-control form-control-sm"
                  placeholder="Search..."
                  aria-label="Search..."
                  aria-describedby="basic-addon-search31"
                  :value="store.search"
                  @keyup="handleSearch"
                />
              </div>
            </div>
          </CardHeader>

          <template #head>
            <Heading sortable>Title</Heading>
            <Heading sortable>Collections</Heading>
            <Heading sortable>Tags</Heading>
            <Heading sortable>Price</Heading>
            <Heading></Heading>
          </template>

          <template #body>
            <template v-if="store.totalDocuments > 0">
              <transition-group name="fade">
                <Row v-for="document in store.documents" :key="document.id">
                  <Cell>
                    <div class="d-flex align-items-center">
                      <i
                        class="tf-icons cursor-pointer bx"
                        v-if="type === 'document'"
                        :class="
                          document.type != 'link' ? 'bx-file' : 'bx-link-alt'
                        "
                        style="font-size: 30px; color: #ffab00"
                        @click="store.handleDocumentSelect(document)"
                      >
                      </i>
                      <i
                        class="tf-icons cursor-pointer bx"
                        v-else
                        :class="
                          document.type != 'link' ? 'bx-file' : 'bx-link-alt'
                        "
                        style="font-size: 30px; color: #ffab00"
                      >
                      </i>
                      <div class="d-flex flex-column ms-2">
                        <span class="fw-semibold lh-1">{{
                          document.title
                        }}</span>
                        <small class="text-muted text-uppercase">{{
                          document.type
                        }}</small>
                      </div>
                    </div>
                  </Cell>
                  <Cell>
                    <span
                      class="badge bg-label-secondary me-1"
                      v-for="collection in document.collections"
                      :key="collection.id"
                    >
                      {{ collection.title }}
                    </span>
                  </Cell>
                  <Cell>
                    {{ document.tags.join(", ") }}
                  </Cell>
                  <Cell>
                    <small
                      v-if="document.is_free"
                      class="badge bg-label-success"
                      >Free</small
                    >
                    <div class="text-muted lh-1" v-else>
                      <span class="text-info fw-semibold"
                        >${{ document.price }}</span
                      >
                    </div>
                  </Cell>
                  <Cell class="text-nowrap">
                    <div
                      class="d-flex justify-content-end"
                      v-if="type == 'document'"
                    >
                      <button
                        type="button"
                        class="btn btn-sm btn-primary"
                        @click="store.handleBuyClick(document)"
                        v-if="document.status === 'published'"
                      >
                      <i class="menu-icon tf-icons bx bx-cart"></i>
                        Add To Cart
                      </button>



                      <a
                        :href="'accessDocument/' + document.enc_id"
                        target="_blank"
                        v-if="document.type === 'link' && document.status === 'Already Buy'"
                        class="btn btn-icon me-2 btn-label-secondary"
                      >
                        <span class="tf-icons bx bx-right-arrow-alt"></span>
                      </a>
                      <a
                        :href="'accessDocument/' + document.enc_id"
                        v-else-if="document.type !== 'link' && document.status === 'Already Buy'"

                        class="btn btn-icon me-2 btn-label-secondary"
                      >
                        <span class="tf-icons bx bx-download"></span>
                      </a>

                      <!-- <button
                        type="button"
                        class="btn btn-sm btn-warning"
                        v-else-if="document.status === 'Already Buy'"
                      >
                        ALREADY BUY
                      </button> -->
                    </div>

                    <div class="d-flex justify-content-end" v-else>
                      <a
                        :href="'accessDocument/' + document.enc_id"
                        target="_blank"
                        v-if="document.type === 'link'"
                        class="btn btn-icon me-2 btn-label-secondary"
                      >
                        <span class="tf-icons bx bx-right-arrow-alt"></span>
                      </a>
                      <a
                        :href="'accessDocument/' + document.enc_id"
                        v-else

                        class="btn btn-icon me-2 btn-label-secondary"
                      >
                        <span class="tf-icons bx bx-download"></span>
                      </a>
                    </div>
                  </Cell>
                </Row>
              </transition-group>
            </template>

            <template v-else>
              <Row>
                <td colspan="5">
                  <not-found
                    height="70vh"
                    :message="store.emptyMsg"
                    v-if="type === 'document'"
                  ></not-found>
                  <not-found
                    height="70vh"
                    message="No documents found!"
                    v-else
                  ></not-found>
                </td>
              </Row>
            </template>
          </template>

          <template #footer>
            <Pagination
              class="float-right"
              :meta="store.meta"
              @event-action="pageChange"
            ></Pagination>
          </template>
        </Datatable>

        <Modal
          :show="store.showModal"
          @close="store.showModal = false"
          :title="store.selectedDocument.title"
        >
          <template #body>
            <span class="badge bg-success" v-if="store.selectedDocument.is_free"
              >FREE</span
            >

            <span v-else class="badge bg-success">
              ${{ store.selectedDocument.price }}
            </span>
            <div v-html="store.selectedDocument.summary"></div>

            <ModalFooter class="float-right pb-2">
              <button
                type="button"
                class="btn btn-danger"
                @click="store.handleBuyClick(document)"
              >
                BUY NOW
              </button>
            </ModalFooter>
          </template>
        </Modal>
      </div>
    </div>
  </div>
</template>
