<div class="row  mt-2 g-3">
    <div class="col-md-12">
        <div class="text-body fw-semibold mb-3">Other areas of interest - </div>
    </div>

    <div class="col-md-4" 
        v-for="otherArea in otherAreas" 
        :key="otherArea.id"
    >
        <div v-if="otherArea.children.length > 0" 
            :class="{
                'btn-group dropend d-flex': true,
                'bg-label-primary': other_main_area[otherArea.id]?.length > 0
            }"
        >
            <button type="button" class="flex-grow-1 d-block text-truncate text-start btn px-3 list-group-item-action btn-parent border border-end-0 shadow-none">
                {{ otherArea.name }}
            </button>
            <button type="button" 
                class="btn btn-icon hide-arrow dropdown-toggle dropdown-toggle-split px-2 border list-group-item-action w-auto shadow-none" 
                data-bs-toggle="dropdown" 
                data-bs-auto-close="outside" 
                aria-haspopup="true" 
                aria-expanded="false">
                <i class="bx bx-chevron-right fs-3"></i>
                <!-- <svg aria-hidden="true" 
                    focusable="false" 
                    data-prefix="fas" 
                    data-icon="cog" 
                    role="img" 
                    xmlns="http://www.w3.org/2000/svg" 
                    viewBox="0 0 512 512" 
                    class="svg-inline--fa fa-cog fa-w-16 fa-spin fa-fw"
                >
                    <path fill="currentColor" d="M487.4 315.7l-42.6-24.6c4.3-23.2 4.3-47 0-70.2l42.6-24.6c4.9-2.8 7.1-8.6 5.5-14-11.1-35.6-30-67.8-54.7-94.6-3.8-4.1-10-5.1-14.8-2.3L380.8 110c-17.9-15.4-38.5-27.3-60.8-35.1V25.8c0-5.6-3.9-10.5-9.4-11.7-36.7-8.2-74.3-7.8-109.2 0-5.5 1.2-9.4 6.1-9.4 11.7V75c-22.2 7.9-42.8 19.8-60.8 35.1L88.7 85.5c-4.9-2.8-11-1.9-14.8 2.3-24.7 26.7-43.6 58.9-54.7 94.6-1.7 5.4.6 11.2 5.5 14L67.3 221c-4.3 23.2-4.3 47 0 70.2l-42.6 24.6c-4.9 2.8-7.1 8.6-5.5 14 11.1 35.6 30 67.8 54.7 94.6 3.8 4.1 10 5.1 14.8 2.3l42.6-24.6c17.9 15.4 38.5 27.3 60.8 35.1v49.2c0 5.6 3.9 10.5 9.4 11.7 36.7 8.2 74.3 7.8 109.2 0 5.5-1.2 9.4-6.1 9.4-11.7v-49.2c22.2-7.9 42.8-19.8 60.8-35.1l42.6 24.6c4.9 2.8 11 1.9 14.8-2.3 24.7-26.7 43.6-58.9 54.7-94.6 1.5-5.5-.7-11.3-5.6-14.1zM256 336c-44.1 0-80-35.9-80-80s35.9-80 80-80 80 35.9 80 80-35.9 80-80 80z"></path>
                </svg> -->
            </button>

            <ul class="dropdown-menu">
                <li v-for="(subArea, idx) in otherArea.children" 
                    :key="`other-area-${idx}`">
                    <a class="dropdown-item" href="javascript:void(0);">
                        <CustomCheckbox 
                            type="checkbox"
                            as="checkbox"
                            class="col-md-4"
                            name="areas_of_interest"
                            :label="subArea.name" 
                            :value="subArea.id" 
                        />
                    </a>      
                </li>
            </ul>
        </div>
                
        <CustomCheckbox v-else
            type="checkbox"
            name="areas_of_interest" 
            :label="otherArea.name" 
            :value="otherArea.id" 
        />
    </div>
</div>    