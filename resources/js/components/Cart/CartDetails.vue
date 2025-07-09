<script setup>
import { ref, computed, onMounted } from "vue";
import { useDocumentStore } from "@/stores/DocumentStore";

const props = defineProps({
  cartItems: null,
});

onMounted(() => {
  store.getCartItems();
});

const currentStep = ref("cart");

const store = useDocumentStore();

const showPaymentStep = computed(() => {
  return totalPrice.value > 0;
});

const purchaseDocumentLink = () => {
  return "/purchase-documents"; // Replace this with the actual route or URL for downloading the invoice
};

const totalItems = computed(() => {
  const items =
    props.cartItems && props.cartItems != "null"
      ? JSON.parse(props.cartItems)
      : [];

  return items.length > 0 ? items.length : store.cartItems?.length;
});

const totalPrice = computed(() => {
  const total = cartItems.value.reduce((total, item) => total + item.price, 0);
  return total.toFixed(2);
});

const cartItems = computed(() => {
  return store.cartItems || [];
});
</script>


<template>
  <div class="bs-stepper-header m-auto border-0">
    <div class="step one" data-target="#account-details">
      <button type="button" class="step-trigger">
        <span class="bs-stepper-icon">
          <i class="bx bx-cart-alt"></i>
        </span>
        <span class="bs-stepper-label">Cart Details</span>
      </button>
    </div>
    <div class="line" v-if="showPaymentStep">
      <i class="bx bx-chevron-right"></i>
    </div>
    <div class="step two" v-if="showPaymentStep" data-target="#personal-info">
      <button type="button" class="step-trigger">
        <span class="bs-stepper-icon">
          <i class="bx bx-wallet"></i>
        </span>
        <span class="bs-stepper-label">Payment</span>
      </button>
    </div>
    <div class="line">
      <i class="bx bx-chevron-right"></i>
    </div>
    <div class="step three" data-target="#address">
      <button type="button" class="step-trigger">
        <span class="bs-stepper-icon">
          <i class="bx bx-check-square"></i>
        </span>
        <span class="bs-stepper-label">Confirmation</span>
      </button>
    </div>
  </div>
  <div id="account-details" class="content">
    <div class="row">
      <div class="col-xl-8 mb-3 mb-xl-0">
        <!-- Offer alert -->
        <!-- <div class="alert alert-success mb-4" role="alert">
          <div class="d-flex gap-3">
            <div class="flex-shrink-0">
              <span
                class="badge badge-center rounded-pill bg-success border-label-success p-3 me-2"
              >
                <i class="bx bx-sm bx-purchase-tag fs-4"></i>
              </span>
            </div>
            <div class="flex-grow-1">
              <div class="fw-bold">Note:</div>
              <ul class="list-unstyled mb-0">
                <li>
                  - Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                  Aenean commodo ligula eget dolor.
                </li>
                <li>
                  - Aenean massa. Cum sociis natoque penatibus et magnis dis
                  parturient montes, nascetur
                </li>
              </ul>
            </div>
          </div>
          <button
            type="button"
            class="btn-close btn-pinned"
            data-bs-dismiss="alert"
            aria-label="Close"
          ></button>
        </div> -->

        <h5>My Shopping Bag ({{ totalItems }} Items)</h5>
        <ul class="list-group mb-3">
          <li
            v-for="(item, index) in cartItems"
            :key="index"
            class="list-group-item p-4"
          >
            <div class="d-flex gap-3">
              <div
                class="flex-shrink-0 d-flex align-items-center justify-content-center"
              >
                <i
                  class="tf-icons"
                  :class="{
                    'bx bx-file': item.type === 'file',
                    'bx bx-link-alt': item.type === 'link',
                  }"
                  style="font-size: 70px; color: #ffab00"
                ></i>
              </div>

              <div class="flex-grow-1">
                <div class="row">
                  <div class="col-md-8">
                    <h6 class="me-3">
                      <a href="javascript:void(0)" class="text-body">{{
                        item.title
                      }}</a>
                    </h6>
                    <div class="text-muted mb-1 d-flex flex-wrap">
                      <span class="me-1">Tags:</span>
                      <a
                        v-for="(tag, tagIndex) in item.tags"
                        :key="tagIndex"
                        href="javascript:void(0)"
                        class="me-1"
                        >{{ tag }}</a
                      >
                    </div>
                    <div class="text-muted mb-1 d-flex flex-wrap">
                      <span class="me-1">Collections:</span>
                      <span
                        v-for="(
                          collection, collectionIndex
                        ) in item.collections"
                        :key="collectionIndex"
                        class="badge bg-label-success me-1"
                        >{{ collection.title }}</span
                      >
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="text-md-end">
                      <button
                        type="button"
                        class="btn-close btn-pinned"
                        aria-label="Close"
                        @click.prevent="store.deleteCart(item.id)"
                      ></button>
                      <div class="my-2 my-md-4">
                        <span class="text-primary" v-if="item.is_free"
                          >Free</span
                        >
                        <span class="text-primary" v-else
                          >${{ item.price }}</span
                        >
                      </div>
                      <button
                        type="button"
                        class="btn btn-sm btn-label-secondary"
                      >
                        {{ item.type === "file" ? "PDF" : "LINK" }}
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </li>
        </ul>
      </div>

      <!-- Cart right -->
      <div class="col-xl-4">
        <div class="border rounded p-3 mb-3">
          <!-- Offer -->
          <!-- <h6>Offer</h6>
          <div class="row g-3 mb-3">
            <div class="col-8 col-xxl-8 col-xl-12">
              <input
                type="text"
                class="form-control"
                placeholder="Enter Promo Code"
                aria-label="Enter Promo Code"
              />
            </div>
            <div class="col-4 col-xxl-4 col-xl-12">
              <div class="d-grid">
                <button type="button" class="btn btn-label-primary">
                  Apply
                </button>
              </div>
            </div>
          </div> -->

          <!-- Gift wrap -->
          <!-- <div class="bg-lighter rounded p-3">
            <p class="fw-semibold">Buying gift for a loved one?</p>
            <p>Gift wrap and personalized message on card, Only for $2.</p>
             <a href="javascript:void(0)" class="fw-semibold">Add a gift wrap</a> -->
          <!-- </div>
          <hr class="mx-n3" /> -->
          <!-- Price Details -->
          <h6>Price Details</h6>
          <dl class="row mb-0">
            <dt class="col-6 fw-normal">Bag Total</dt>
            <dd class="col-6 text-end">${{ totalPrice }}</dd>

            <!-- <dt class="col-6 fw-normal">Coupon Discount</dt>
            <dd class="col-6 text-success text-end">-$48.00</dd> -->

            <dt class="col-6 fw-normal">Order Total</dt>
            <dd class="col-6 text-end">${{ totalPrice }}</dd>

            <hr class="m-0 mb-2" />
            <!-- <dt class="col-6 fw-bold fst-italic text-muted">GST (10%)</dt> -->
            <!-- <dd class="col-6 fw-bold fst-italic text-muted text-end">$35.00</dd> -->

            <hr />

            <dt class="col-6">Total</dt>
            <dd class="col-6 fw-semibold text-end mb-0">${{ totalPrice }}</dd>
          </dl>
        </div>
        <div class="d-grid">
          <button
            class="btn btn-primary btn-next"
            @click.prevent="store.storeCartItems()"
            v-if="showPaymentStep == 0"
          >
            Place Order
          </button>
          <button class="btn btn-primary btn-next" v-else>Place Order</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Personal Info -->
  <div id="personal-info" class="content">
    <div class="row">
      <!-- Payment left -->
      <div class="col-xl-9 mb-3 mb-xl-0">
        <!-- Offer alert -->
        <!-- <div class="alert alert-success" role="alert">
          <div class="d-flex gap-3">
            <div class="flex-shrink-0">
              <span
                class="badge badge-center rounded-pill bg-success border-label-success p-3 me-2"
              >
                <i class="bx bx-sm bx-purchase-tag fs-4"></i>
              </span>
            </div>
            <div class="flex-grow-1">
              <div class="fw-bold">Note:</div>
              <ul class="list-unstyled mb-0">
                <li>
                  - Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                  Aenean commodo ligula eget dolor.
                </li>
                <li>
                  - Aenean massa. Cum sociis natoque penatibus et magnis dis
                  parturient montes, nascetur
                </li>
              </ul>
            </div>
          </div>
          <button
            type="button"
            class="btn-close btn-pinned"
            data-bs-dismiss="alert"
            aria-label="Close"
          ></button>
        </div> -->

        <!-- Payment Tabs -->
        <div class="col-xxl-6 col-lg-8" v-if="totalPrice > 0">
          <div class="tab-content" id="paymentTabsContent">
            <!-- Credit card -->
            <div
              class="tab-pane fade show active"
              id="pills-cc"
              role="tabpanel"
              aria-labelledby="pills-cc-tab"
            >
              <div class="row g-3">
                <div class="col-12">
                  <label class="form-label w-100" for="paymentCard"
                    >Card Number</label
                  >
                  <div class="input-group input-group-merge">
                    <input
                      id="paymentCard"
                      name="paymentCard"
                      class="form-control credit-card-mask"
                      type="text"
                      placeholder="1356 3215 6548 7898"
                      aria-describedby="paymentCard2"
                    />
                    <span
                      class="input-group-text cursor-pointer p-1"
                      id="paymentCard2"
                      ><span class="card-type"></span
                    ></span>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <label class="form-label" for="paymentCardName">Name</label>
                  <input
                    type="text"
                    id="paymentCardName"
                    class="form-control"
                    placeholder="John Doe"
                  />
                </div>
                <div class="col-6 col-md-3">
                  <label class="form-label" for="paymentCardExpiryDate"
                    >Exp. Date</label
                  >
                  <input
                    type="text"
                    id="paymentCardExpiryDate"
                    class="form-control expiry-date-mask"
                    placeholder="MM/YY"
                  />
                </div>
                <div class="col-6 col-md-3">
                  <label class="form-label" for="paymentCardCvv"
                    >CVV Code</label
                  >
                  <div class="input-group input-group-merge">
                    <input
                      type="text"
                      id="paymentCardCvv"
                      class="form-control cvv-code-mask"
                      maxlength="3"
                      placeholder="654"
                    />
                    <span
                      class="input-group-text cursor-pointer"
                      id="paymentCardCvv2"
                    >
                      <i
                        class="bx bx-help-circle text-muted"
                        data-bs-toggle="tooltip"
                        data-bs-placement="top"
                        title="Card Verification Value"
                      ></i>
                    </span>
                  </div>
                </div>

                <div class="col-12">
                  <button
                    type="button"
                    class="btn btn-primary btn-next me-sm-3 me-1"
                    @click.prevent="store.storeCartItems()"
                  >
                    Submit
                  </button>
                  <button type="reset" class="btn btn-label-secondary">
                    Cancel
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Address right -->
      <div class="col-xl-3">
        <div class="border rounded p-3 mb-3">
          <!-- Price Details -->

          <h6>Price Details</h6>
          <dl class="row mb-0">
            <dt class="col-6 fw-normal">Bag Total</dt>
            <dd class="col-6 text-end">${{ totalPrice }}</dd>

            <!-- <dt class="col-6 fw-normal">Coupon Discount</dt>
            <dd class="col-6 text-success text-end">-$48.00</dd> -->

            <dt class="col-6 fw-normal">Order Total</dt>
            <dd class="col-6 text-end">${{ totalPrice }}</dd>

            <hr class="m-0 mb-2" />
            <!--
            <dt class="col-6 fw-bold text-muted fst-italic">GST (10%)</dt>
            <dd class="col-6 fw-bold text-end text-muted fst-italic">$35.00</dd> -->

            <hr />

            <dt class="col-6">Total</dt>
            <dd class="col-6 fw-semibold text-end mb-0">${{ totalPrice }}</dd>
            <hr />
            <div class="col-12" v-if="totalPrice == 0">
              <button
                type="button"
                class="btn btn-primary btn-next me-sm-3 me-1"
                @click.prevent="store.storeCartItems()"
              >
                Submit
              </button>
              <button type="reset" class="btn btn-label-secondary">
                Cancel
              </button>
            </div>
          </dl>
        </div>
      </div>
    </div>
  </div>

  <!-- Address -->
  <div id="address" class="content">
    <div class="row mb-3">
      <div class="col-12 col-lg-8 offset-lg-2 text-center mb-3">
        <h4 class="mt-2">Thank You! 😇</h4>
        <p>
          Your order
          <a href="javascript:void(0)">#{{ store.orderInfo.order_no }}</a> has
          been placed!
        </p>
        <p>
          We sent an email to
          <a href="mailto:">{{ store.orderInfo.email }}</a> with your order
          confirmation and receipt. If the email hasn't arrived within two
          minutes, please check your spam folder to see if the email was routed
          there.
        </p>
        <p>
          <span class="fw-semibold"
            ><i class="bx bx-time-five"></i> Time placed:</span
          >
          {{ store.orderInfo.formatted_created_at }}
        </p>
        <a :href="purchaseDocumentLink()" class="btn btn-sm btn-warning"
          >Our Purchased Documents</a
        >
      </div>
    </div>

    <div class="row">
      <!-- Cart left -->
      <div class="col-xl-8 mb-3 mb-xl-0">
        <ul class="list-group mb-3">
          <li
            v-for="(item, index) in cartItems"
            :key="index"
            class="list-group-item p-4"
          >
            <div class="d-flex gap-3">
              <div
                class="flex-shrink-0 d-flex align-items-center justify-content-center"
              >
                <i
                  class="tf-icons"
                  :class="{
                    'bx bx-file': item.type === 'file',
                    'bx bx-link-alt': item.type === 'link',
                  }"
                  style="font-size: 70px; color: #ffab00"
                ></i>
              </div>

              <div class="flex-grow-1">
                <div class="row">
                  <div class="col-md-8">
                    <h6 class="me-3">
                      <a href="javascript:void(0)" class="text-body">{{
                        item.title
                      }}</a>
                    </h6>
                    <div class="text-muted mb-1 d-flex flex-wrap">
                      <span class="me-1">Tags:</span>
                      <a
                        v-for="(tag, tagIndex) in item.tags"
                        :key="tagIndex"
                        href="javascript:void(0)"
                        class="me-1"
                        >{{ tag }}</a
                      >
                    </div>
                    <div class="text-muted mb-1 d-flex flex-wrap">
                      <span class="me-1">Collections:</span>
                      <span
                        v-for="(
                          collection, collectionIndex
                        ) in item.collections"
                        :key="collectionIndex"
                        class="badge bg-label-success me-1"
                        >{{ collection.title }}</span
                      >
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="text-md-end">
                      <div class="my-2 my-md-4">
                        <span class="text-primary" v-if="item.is_free"
                          >Free</span
                        >
                        <span class="text-primary" v-else
                          >${{ item.price }}</span
                        >
                      </div>
                      <button
                        type="button"
                        class="btn btn-sm btn-label-secondary"
                      >
                        {{ item.type === "file" ? "PDF" : "LINK" }}
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </li>
        </ul>
      </div>

      <!-- Cart right -->
      <div class="col-xl-4">
        <div class="border rounded p-3 mb-3">
          <!-- Price Details -->
          <h6>Price Details</h6>
          <dl class="row mb-0">
            <dt class="col-6 fw-normal">Bag Total</dt>
            <dd class="col-6 text-end">${{ totalPrice }}</dd>

            <!-- <dt class="col-6 fw-normal">Coupon Discount</dt>
                                            <dd class="col-6 text-success text-end"> -$48.00</dd> -->

            <dt class="col-6 fw-normal">Order Total</dt>
            <dd class="col-6 text-end">${{ totalPrice }}</dd>

            <hr class="m-0 mb-2" />

            <!-- <dt class="col-6 fw-bold text-muted fst-italic">GST (10%)</dt>
                                            <dd class="col-6 fw-bold text-end text-muted fst-italic">$35.00</dd> -->

            <hr />

            <dt class="col-6">Total</dt>
            <dd class="col-6 fw-semibold text-end mb-0">${{ totalPrice }}</dd>
          </dl>
        </div>
      </div>
    </div>
  </div>
</template>
