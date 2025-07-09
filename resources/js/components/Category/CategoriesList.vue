<script setup>
import {useCategoryComposable} from "@/composables/category/category.composable";

const {
        statusBgClass,
        store,
        search,
        createHandler,
        sortByColumn,
        fetch,
        pageChange
      } = useCategoryComposable();
</script>

<template>
  <div class="col-12">
    <div class="card">
      <Datatable table-class="less-padding">
        <CardHeader title="Categories">
          <div class="dt-buttons">
            <button class="btn btn-info btn-sm fw-semibold" type="button" @click="createHandler">
              <i class="bx bx-plus me-2"></i> <span class="d-none d-lg-inline-block">Add New Record</span>
            </button>
          </div>
          <div class="mt-3">
            <input v-model="search"
                   class="form-control form-control-sm rounded-pill"
                   placeholder="Search category..."/>
          </div>
        </CardHeader>


        <template #head>
          <Heading>Parent</Heading>
          <Heading @click="sortByColumn('name')">Name</Heading>
          <Heading>Created At</Heading>
          <Heading>Status</Heading>
          <Heading :sortable="false">Action</Heading>
        </template>

        <template #body>
          <template v-if="store.totalCategory > 0">
            <transition-group name="fade">
              <Row v-for="category in store.categories" :key="category.id">
                <Cell>{{ category?.parent?.name || '--' }}</Cell>
                <Cell>{{ category.name }}</Cell>
                <Cell>{{ category.created }}</Cell>
                <Cell>
                                    <span class="text-capitalize badge rounded px-3"
                                          :class="statusBgClass(category.status)"
                                          v-text="category.status"></span>
                </Cell>
                <Cell>
                  <a href="javascript:void(0);" class="btn btn-sm btn-icon"
                     @click.prevent="store.editHandler(category)">
                    <i class="bx bxs-edit"></i>
                  </a>
                  <a href="javascript:void(0);" class="btn btn-sm btn-icon"
                     @click.prevent="store.delete(category)">
                    <i class="bx bx-trash"></i>
                  </a>
                </Cell>
              </Row>
            </transition-group>
          </template>

          <template v-else>
            <Row>
              <td colspan="7">
                <div class="d-flex justify-content-center align-items-center">
                                    <span
                                        class="font-medium py-8 text-cool-gray-400 text-xl">
                                      {{ store.loading ? 'Loading...' : 'No categories found!' }}
                                    </span>
                </div>
              </td>
            </Row>
          </template>
        </template>

        <template #footer>
          <Pagination :meta="store.meta" @changed="pageChange"></Pagination>
        </template>
      </Datatable>
    </div>
  </div>
</template>
