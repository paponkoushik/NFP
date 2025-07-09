<script setup>
import { computed } from 'vue';
import { useOrgSettingsStore } from "@/stores/OrgSettingsStore";
import CustomCheckbox from '@/components/Shared/CustomCheckbox';
import GroupDropdown from '@/components/Organisations/Form/GroupDropdown';

const { serviceAreas, organisation } = useOrgSettingsStore();
const groupedServiceAreas = computed(() => organisation.groupedServiceAreas);

const toggle = (parentId, targetValue) => {
    const grouped = organisation.groupedServiceAreas[parentId];

    if(grouped && grouped.includes(targetValue)) {
        grouped.splice(grouped.indexOf(targetValue), 1);
        return;
    }

    organisation.groupedServiceAreas[parentId] = !grouped ?  [targetValue] : [...grouped, targetValue];
};

</script>

<template>
    <div class="content active dstepper-block">
        <div class="content-header mb-3">
            <h5 class="mb-1">Service Areas</h5>
            <small>Pick the Service Areas you work</small>
        </div>

        <div class="row g-3">
            <div v-for="(area, idx) in serviceAreas" :key="idx" class="col-md-6 mb-2">
                <GroupDropdown
                    v-if="area.children.length"
                    :label="area.name"
                    :is-selected="groupedServiceAreas[area.id]?.length"
                    :selected-values="groupedServiceAreas[area.id]"
                >
                    <li v-for="(subcat, sidx) in area.children" :key="`sub-${sidx}`">
                        <a class="dropdown-item" href="javascript:void(0);">
                            <CustomCheckbox
                                @change="toggle(area.id, subcat.name)"
                                class="col-md-4"
                                as="checkbox"
                                type="checkbox"
                                name="service_areas"
                                :label="subcat.name"
                                :value="subcat.id" />
                        </a>
                    </li>
                </GroupDropdown>

                <CustomCheckbox v-else
                    class="btn-group dropend d-flex col-10"
                    classes="flex-grow-1 d-block text-truncate text-start btn px-3 list-group-item-action border shadow-none"
                    as="button"
                    name="service_areas"
                    :label="area.name"
                    :value="area.id" />
            </div>

            <ErrorMessage class="invalid-feedback d-block" name="service_areas" />
        </div>
    </div>
</template>
