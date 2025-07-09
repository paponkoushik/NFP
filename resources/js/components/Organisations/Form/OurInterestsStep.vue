<script setup>
import CustomCheckbox from '@/components/Shared/CustomCheckbox';
import GroupDropdown from '@/components/Organisations/Form/GroupDropdown';
import {useOurInterestsComposable} from "../../../composables/organization/steps/our_interests.composable";

const {
          store,
          interests,
          groupedOurInterests,
          toggle
      } = useOurInterestsComposable();

</script>

<template>
    <div class="content active dstepper-block">
        <div class="content-header mb-3">
            <h5 class="mb-1">Our Interests</h5>
            <small>Please lets us know what you are looking from this platform. This will help us to find any macthing
                interests and will send you the matched organisation lists in your daily emails</small>
        </div>

        <div class="row gap-md-0 gap-3">
            <div class="col-md-12 text-body fw-semibold mb-2">We are looking for -</div>

            <div v-for="(interest, idx) in interests" :key="idx" class="col-md-6 mb-2">
                <GroupDropdown
                    v-if="interest.childs.length"
                    class="col-10"
                    :label="interest.name"
                    :is-selected="groupedOurInterests[interest.code]?.length"
                    :selected-values="groupedOurInterests[interest.code]"
                >

                    <li v-for="(child1, c1Idx) in interest.childs" :key="`sub-${c1Idx}`">
                        <GroupDropdown
                            v-if="child1.childs.length"
                            class="mb-2 mx-2"
                            :label="child1.name"
                            :is-selected="groupedOurInterests[interest.code]?.[child1.code]?.length"
                            :selected-values="groupedOurInterests[interest.code]?.[child1.code]"
                        >
                            <li v-for="(child2, c2Idx) in child1.childs" :key="`sub-${c2Idx}`">
                                <a class="dropdown-item" href="javascript:void(0);">
                                    <CustomCheckbox
                                        @change="toggle(child2, child1.code, interest.code)"
                                        class="col-md-4"
                                        as="checkbox"
                                        type="checkbox"
                                        name="our_interests"
                                        :label="child2.name"
                                        :value="child2.id"/>
                                </a>
                            </li>
                        </GroupDropdown>

                        <a v-else class="dropdown-item" href="javascript:void(0);">
                            <CustomCheckbox
                                @change="toggle(child1, interest.code)"
                                class="col-md-4"
                                as="checkbox"
                                type="checkbox"
                                name="our_interests"
                                :label="child1.name"
                                :value="child1.id"/>
                        </a>
                    </li>
                </GroupDropdown>

                <CustomCheckbox v-else
                                @click="toggle(interest)"
                                class="btn-group dropend d-flex col-10"
                                classes="flex-grow-1 d-block text-truncate text-start btn px-3 list-group-item-action border shadow-none"
                                as="button"
                                name="our_interests"
                                :label="interest.name"
                                :value="interest.id"/>
            </div>

            <ErrorMessage class="invalid-feedback d-block" name="our_interests"/>
        </div>
    </div>
</template>
