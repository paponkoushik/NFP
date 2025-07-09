<script setup>
import { ref, onMounted, watch } from "vue";
import { useDashboardStore } from "@/stores/DashboardStore";
import { useUrlFunc } from "@/composables/useUrlFunc.js";
import LegalFilters from "@/components/Legals/Dashboard/LegalFilter";
import NewListing from "@/components/Legals/Dashboard/ListingNew";
import ListingOrgAdmin from "@/components/Legals/ListingOrgAdmin";
import LawyerFilter from "@/components/Legals/Dashboard/LawyerFilter";

defineProps({
  statuses: Array,
  can: Object,
});

const store = useDashboardStore();
const chartSeries = ref([]);
const ProfitSeries = ref([]);
const monthRevenueSeries = ref([{ data: [""] }]);
const totalRevWithMonthSeries = ref([]);
const performanceSeries = ref([]);
const lawyerRatingsSeries = ref([{}]);

const performanceOptions = {
  chart: {
    sparkline: {
      enabled: true,
    },
    parentHeightOffset: 0,
    type: "radialBar",
  },
  colors: ["#28a745"], // Adjust the color as needed
  plotOptions: {
    radialBar: {
      startAngle: -90,
      endAngle: 90,
      hollow: {
        size: "65%",
      },
      track: {
        background: "#6c757d", // Adjust the background color as needed
      },
      dataLabels: {
        name: {
          show: false,
        },
        value: {
          fontSize: "22px",
          color: "#333", // Adjust the color as needed
          fontWeight: 500,
          offsetY: 0,
        },
      },
    },
  },
  grid: {
    show: false,
    padding: {
      left: -10,
      right: -10,
    },
  },
  stroke: {
    lineCap: "round",
  },
  labels: ["Progress"],
};

const lawyerRatingsOptions = {
  chart: {
    height: 400,
    type: "scatter",
    zoom: {
      enabled: true,
      type: "xy",
    },
    parentHeightOffset: 0,
    toolbar: {
      show: false,
    },
  },
  grid: {
    borderColor: "#eceef1",
    xaxis: {
      lines: {
        show: true,
      },
    },
  },
  legend: {
    show: true,
    position: "top",
    horizontalAlign: "start",
    labels: {
      colors: "#697a8d",
      useSeriesColors: false,
    },
  },
  colors: [config.colors.warning, config.colors.primary, config.colors.success],

  xaxis: {
    tickAmount: 10,
    axisBorder: {
      show: false,
    },
    axisTicks: {
      show: false,
    },
    labels: {
      formatter: function (val) {
        return parseFloat(val).toFixed(1);
      },
      style: {
        colors: "#a1acb8",
        fontSize: "13px",
      },
    },
  },
  yaxis: {
    labels: {
      style: {
        colors: "#7071a4",
        fontSize: "13px",
      },
    },
  },
};

onMounted(() => {
  store.fill();
  updateChartData();
});

watch(
  () => store.cardData,
  () => {
    updateChartData();
  }
);

function updateChartData() {
  const cardData = store.cardData;

  if (cardData) {
    updateRevenueChartData(cardData.getYearlyRevenueByMonth);
    updateChartSeries(cardData.getTotalRevenueByDayOfWeek);
    updateProfitChartData(cardData.getTotalReqAndProByMonth);
    updatePerformanceChartData(cardData.performance);
    updateMonthRevenueChartData(cardData.getDailyRevenue);
    updateLawyerRatingsData(cardData.getLawyerRatingsData);
  }
}

// function updateRevenueChartData(data) {
//   if (data) {
//     // Extract the months with values from the data
//     const monthNames = Object.keys(data);

//     // Check if there are months with values
//     if (monthNames.length > 0) {
//       // Transform the data into the format required by your chart library
//       const seriesData = Object.values(data);

//       // Update the chart series data and x-axis categories
//       totalRevWithMonthSeries.value = [{ data: seriesData }];

//     }
//   }
// }
function updateRevenueChartData(data) {
  if (data) {
    // Extract the months with values from the data
    const monthNames = Object.keys(data);

    // Check if there are months with values
    if (monthNames.length > 0) {
      // Update the chart x-axis categories to match the month names
      const seriesData = monthNames.map((month) =>
        data[month] ? data[month] : 0
      );
      // Update the chart series data
      totalRevWithMonthSeries.value = [{ data: seriesData }];

      // Update the chart x-axis categories to match the month names
      console.log("dfsdfs", monthNames);
      totalRevWithMonthOptions.xaxis = {
        categories: [...monthNames],
        axisBorder: {
          show: false,
        },
        axisTicks: {
          show: false,
        },
        labels: {
          show: true,
          style: {
            fontSize: "13px",
            colors: [
              "#7071a4",
              "#7071a4",
              "#7071a4",
              "#7071a4",
              "#7071a4",
              "#7071a4",
            ],
          },
        },
      };
    }
  }
}

function updateChartSeries(data) {
  if (data) {
    const categories = Object.keys(data);
    const seriesData = Object.values(data);
    chartSeries.value = [{ name: "Total Revenue", data: seriesData }];
    // chartOptions.xaxis.categories = categories;
    chartOptions.xaxis = {
      categories: [...categories],
      axisBorder: {
        show: false,
      },
      axisTicks: {
        show: false,
      },
      labels: {
        style: {
          colors: "#333",
          fontSize: "13px",
        },
      },
    };
  }
}

function updateProfitChartData(data) {
  if (data) {
    const months = Object.keys(data).sort((a, b) => {
      // Sort months here
    });

    const monthName = Object.keys(data);
    const inProgressCounts = months.map(
      (month) => data[month].in_progress_count
    );
    const totalCounts = months.map((month) => data[month].total_count);

    ProfitSeries.value = [
      { name: "In Progress", data: inProgressCounts },
      { name: "Received", data: totalCounts },
    ];
    // Update the chart options dynamically
    profitOptions.xaxis = {
      categories: [...monthName],
      axisBorder: {
        show: false,
      },
      axisTicks: {
        show: false,
      },
      labels: {
        style: {
          colors: "#6c757d", // Adjust label colors as needed
          fontSize: "13px",
        },
      },
    };
  }
}

function updatePerformanceChartData(data) {
  if (data) {
    performanceSeries.value = [data];
  }
}

function updateMonthRevenueChartData(data) {
  if (data) {
    const monthName = Object.keys(data);
    const seriesData = Object.values(data);
    monthRevenueSeries.value = [{ data: seriesData }];
  }
}

function updateLawyerRatingsData(data) {
  if (data) {
    // Initialize an empty array to store the updated series data
    const updatedSeries = [];

    // Iterate through the lawyers in the backend response
    for (const lawyerName in data) {
      if (data.hasOwnProperty(lawyerName)) {
        const lawyerData = data[lawyerName];

        // Check if lawyerData is an object
        if (typeof lawyerData === "object" && !Array.isArray(lawyerData)) {
          // Extract the values from the object (e.g., completed_count and in_progress_count)
          const completedCount = parseFloat(lawyerData.completed_count);
          const inProgressCount = parseFloat(lawyerData.in_progress_count);

          const series = {
            name: lawyerName,
            data: [[completedCount, inProgressCount]],
          };

          // Push the series object to the updatedSeries array
          updatedSeries.push(series);
        }
      }
    }
    // Update the lawyerRatingsSeries ref with the updated series data
    lawyerRatingsSeries.value = updatedSeries;
  }
}

const chartOptions = {
  chart: {
    type: "bar",
    height: 80,
    toolbar: {
      show: false,
    },
  },
  plotOptions: {
    bar: {
      barHeight: "80%",
      columnWidth: "75%",
      startingShape: "rounded",
      endingShape: "rounded",
      borderRadius: 2,
      distributed: true,
    },
  },
  grid: {
    show: false,
    padding: {
      top: -20,
      bottom: -12,
      left: -10,
      right: 0,
    },
  },
  colors: [
    "#ff5733",
    "#ff5733",
    "#ff5733",
    "#ff5733",
    "#ff5733",
    "#ff5733",
    "#ff5733",
  ],
  dataLabels: {
    enabled: false,
  },

  legend: {
    show: false,
  },
  xaxis: {
    categories: [],
    axisBorder: {
      show: false,
    },
    axisTicks: {
      show: false,
    },
    labels: {
      style: {
        colors: "#333",
        fontSize: "13px",
      },
    },
  },
  yaxis: {
    labels: {
      show: false,
    },
  },
};

const profitOptions = {
  chart: {
    type: "bar",
    height: 90,
    toolbar: {
      tools: {
        download: false,
      },
    },
  },
  plotOptions: {
    bar: {
      columnWidth: "65%",
      startingShape: "rounded",
      endingShape: "rounded",
      borderRadius: 3,
      dataLabels: {
        show: false,
      },
    },
  },
  grid: {
    show: false,
    padding: {
      top: -30,
      bottom: -12,
      left: -10,
      right: 0,
    },
  },
  colors: ["#1e9ff21a", "#28a745"],
  dataLabels: {
    enabled: false,
  },
  stroke: {
    show: true,
    width: 5,
    colors: "#28a745", // Adjust the stroke color as needed
  },
  legend: {
    show: false,
  },
  xaxis: {
    categories: [], // Use the ref here
    axisBorder: {
      show: false,
    },
    axisTicks: {
      show: false,
    },
    labels: {
      style: {
        colors: "#6c757d", // Adjust label colors as needed
        fontSize: "13px",
      },
    },
  },
  yaxis: {
    labels: {
      show: false,
    },
  },
};

const totalRevWithMonthOptions = {
  chart: {
    height: 225,
    parentHeightOffset: 0,
    parentWidthOffset: 0,
    type: "line",
    dropShadow: {
      enabled: true,
      top: 10,
      left: 5,
      blur: 3,
      color: config.colors.warning,
      opacity: 0.15,
    },
    toolbar: {
      show: false,
    },
  },
  dataLabels: {
    enabled: false,
  },
  stroke: {
    width: 3,
    curve: "smooth",
  },
  legend: {
    show: false,
  },
  colors: [config.colors.warning],
  markers: {
    size: 6,
    colors: "transparent",
    strokeColors: "transparent",
    strokeWidth: 4,
    discrete: [
      {
        fillColor: config.colors.white,
        seriesIndex: 0,
        dataPointIndex: 5,
        strokeColor: config.colors.warning,
        strokeWidth: 8,
        size: 6,
        radius: 8,
      },
    ],
    hover: {
      size: 7,
    },
  },
  grid: {
    show: false,
    padding: {
      top: -10,
      left: 0,
      right: 0,
      bottom: 10,
    },
  },

  yaxis: {
    labels: {
      show: false,
    },
  },
};
</script>

<template>
  <div class="row">
    <div class="col-xl-6 col-lg-3 col-md-4 col-sm-4 col-6 mb-4">
      <div class="card h-100">
        <div class="card-body d-flex flex-column justify-content-between">
          <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 mb-4">
              <span class="d-block mb-2">Completed Requests</span>
              <h3 class="card-title mb-2" v-if="store.cardData.totalCompleted">
                {{ store.cardData.totalCompleted.currentMonthCount }}
              </h3>
              <span
                class="badge bg-label-info mb-3"
                v-if="store.cardData.totalCompleted"
              >
                {{ store.cardData.totalCompleted.percentageChange }}
              </span>
              <small class="text-muted">Than last month</small>
            </div>
            <div
              class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 mb-4"
              v-if="ProfitSeries.length > 0"
            >
              <span class="d-block mb-2">Received vs Processed</span>
              <h3 class="card-title mb-0">
                {{ store.cardData.getTotalReqAndProReq }}
              </h3>
              <apexchart
                width="180"
                type="bar"
                :options="profitOptions"
                :series="ProfitSeries"
                height="80"
                :toolbar="false"
              ></apexchart>
            </div>
            <div v-else>
              <p>No Data Found...</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 mb-4">
      <div class="card h-100">
        <div class="card-body d-flex flex-column justify-content-between">
          <div>
            <span class="d-block mb-2">Total Revenue</span>
            <h3 class="card-title">$ {{ store.cardData.totalRevenue }}</h3>
          </div>
          <div>
            <span class="d-block mb-2">This Month Revenue</span>
            <h3 class="card-title mb-2">
              $ {{ store.cardData.totalRevenueThisMonth }}
            </h3>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 mb-4">
      <div class="card h-100">
        <div class="card-body d-flex flex-column justify-content-between">
          <div>
            <span class="d-block mb-2">This week</span>
            <h3 class="card-title mb-2">
              $ {{ store.cardData.totalRevenueThisWeek }}
            </h3>
          </div>
          <div v-if="chartSeries.length > 0">
            <apexchart
              width="180"
              type="bar"
              :options="chartOptions"
              :series="chartSeries"
              height="80"
              toolbar="false"
            ></apexchart>
          </div>
          <div v-else>
            <p>No Data Found for chart...</p>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 mb-4">
      <div class="card h-100">
        <div class="card-body d-flex flex-column justify-content-between">
          <div>
            <span class="d-block mb-2">Performance</span>
          </div>
          <div>
            <apexchart
              width="180"
              type="radialBar"
              :options="performanceOptions"
              :series="performanceSeries"
              toolbar="false"
            ></apexchart>
          </div>
          <div>
            <small class="text-muted d-block text-center"
              >$21 more than last month</small
            >
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-6 col-lg-8 mb-4">
    <div class="card h-100">
      <LegalFilters />
      <NewListing v-if="can.edit" />

      <ListingOrgAdmin v-else />
    </div>
  </div>

  <!-- Total Balance -->

  <div class="col-md-6 col-lg-4 mb-4">
    <div class="card h-100">
      <div
        class="card-header d-flex align-items-center justify-content-between"
      >
        <h5 class="card-title m-0 me-2">Total Revenue (This Year)</h5>
      </div>
      <div class="card-body" v-if="totalRevWithMonthSeries.length > 0">
        <apexchart
          type="line"
          :options="totalRevWithMonthOptions"
          :series="totalRevWithMonthSeries"
          height="225"
        >
        </apexchart>
        <div class="d-flex justify-content-between">
          <small class="text-muted">
            You have done <span class="fw-bold">57.6%</span> more sales.<br />
            Check your new badge in your profile.
          </small>
          <div>
            <span class="badge bg-label-warning p-2"
              ><i class="bx bx-chevron-right text-warning"></i
            ></span>
          </div>
        </div>
      </div>
      <div v-else>
        <div
          class="d-flex flex-column justify-content-center align-items-center pb-5 pt-3"
        >
          <img
            src="/assets/img/empty-folder.png"
            alt="EMPTY RESULT"
            class="w-px-150"
          />
          <span
            class="font-medium fw-semibold py-8 text-cool-gray-400 text-uppercase text-xl"
          >
            No Data Found For chart!</span
          >
        </div>
      </div>
    </div>
  </div>
  <!--/ Total Balance -->

  <!-- Scatter Chart -->
  <div class="col-12 mb-4">
    <div class="card">
      <div
        class="card-header d-flex justify-content-between align-items-center"
      >
        <h5 class="card-title mb-0">Lawyer Ratings</h5>
        <div
          class="btn-group d-none d-sm-flex"
          role="group"
          aria-label="radio toggle button group"
        >
          <!-- <input type="radio" class="btn-check" name="btnradio" id="dailyRadio" checked autocomplete="off" />
                    <label class="btn btn-outline-secondary" for="dailyRadio">Daily</label>

                    <input type="radio" class="btn-check" name="btnradio" id="monthlyRadio" autocomplete="off" />
                    <label class="btn btn-outline-secondary" for="monthlyRadio">Monthly</label>

                    <input type="radio" class="btn-check" name="btnradio" id="yearlyRadio" autocomplete="off" />
                    <label class="btn btn-outline-secondary" for="yearlyRadio">Yearly</label> -->
          <LawyerFilter></LawyerFilter>
        </div>
      </div>
      <div class="card-body">
        <!-- <div id="scatterChart"></div> -->
        <apexchart
          type="scatter"
          :options="lawyerRatingsOptions"
          :series="lawyerRatingsSeries"
          height="400"
        >
        </apexchart>
      </div>
    </div>
  </div>
  <!-- /Scatter Chart -->
</template>


