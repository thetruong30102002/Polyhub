@extends('Backend.layouts.app')
@section('content')
@if (Auth::check() && (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'supper'))
  <div class="row">
    <div class="col-lg-6 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-body border-bottom position-relative">
          <h5 class="card-title fs-6 mb-1">Congratulations Jonathan</h5>
          <p class="mb-0">You have done 38% more sales</p>
          <div class="mt-6">
            <ul class="list-unstyled mb-0">
              <li class="d-flex align-items-center mb-9">
                <div
                  class="bg-success-subtle p-6 me-3 rounded-circle d-flex align-items-center justify-content-center">
                  <iconify-icon icon="solar:cart-5-line-duotone" class="fs-7 text-success"></iconify-icon>
                </div>
                <div>
                  <h6 class="mb-1 fs-4">64 new orders</h6>
                  <p class="mb-0">Processing</p>
                </div>
              </li>
              <li class="d-flex align-items-center mb-9">
                <div
                  class="bg-warning-subtle p-6 me-3 rounded-circle d-flex align-items-center justify-content-center">
                  <iconify-icon icon="solar:pause-line-duotone" class="fs-6 text-warning"></iconify-icon>
                </div>
                <div>
                  <h6 class="mb-1 fs-4">4 orders</h6>
                  <p class="mb-0">On hold</p>
                </div>
              </li>
              <li class="d-flex align-items-center">
                <div
                  class="bg-indigo-subtle p-6 me-3 rounded-circle d-flex align-items-center justify-content-center">
                  <iconify-icon icon="solar:bicycling-round-bold-duotone"
                    class="fs-7 text-indigo"></iconify-icon>
                </div>
                <div>
                  <h6 class="mb-1 fs-4">12 orders</h6>
                  <p class="mb-0">Delivered</p>
                </div>
              </li>
            </ul>
            <div class="man-working-on-laptop">
              <img src="{{ asset('storage/images/backgrounds/man-working-on-laptop.png') }}" alt="" class="img-fluid">
            </div>
          </div>
        </div>

        <div class="card-body pb-2">
          <div class="d-flex align-items-baseline justify-content-between">
            <div>
              <h5 class="card-title fs-6 mb-1">Total Tickets</h5>
              <p class="mb-0">Weekly order updates</p>
            </div>
            <select id="timeframe-select" class="form-select fw-bold w-auto shadow-none">
              <option value="1">This Day</option>
              <option value="2">This Week</option>
              <option value="3">This Month</option>
              <option value="4">This Year</option>
            </select>
          </div>
          <div id="netsells"></div>
        </div>

      </div>
    </div>
    <div class="col-lg-6 d-flex align-items-stretch">
      <div class="row">
        <div class="col-sm-6 d-flex align-items-stretch">
          <div class="card w-100">

            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div>
                  <h5 class="card-title mb-1">Best Payments</h5>
                  <p class="mb-0">Last 7 days</p>
                </div>
                <div>
                  <h5 class="card-title mb-1 text-end">12,389</h5>
                  <span class="badge rounded-pill bg-warning-subtle text-warning border-warning border text-end">-3.8%</span>
                </div>
              </div>
              <div id="total-orders" class="total-orders-chart my-1"></div>
            </div>

            
          </div>
        </div>
        <div class="col-sm-6 d-flex align-items-stretch">
          <div class="card w-100">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div>
                  <h5 class="card-title mb-1">Best Movie</h5>
                  <p class="mb-0">Last 7 days</p>
                </div>
                <div>
                  <h5 class="card-title mb-1 text-end">432</h5>
                  <span
                    class="badge rounded-pill bg-success-subtle text-success border-success border text-end">+26.5%</span>
                </div>
              </div>
              <div id="products" class="my-8"></div>
              <p class="mb-0 text-center">$18k Profit more than last month</p>
            </div>
          </div>
        </div>
        <div class="col-sm-6 d-flex align-items-stretch">
          
          <div class="card w-100">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div>
                  <h5 class="card-title mb-1">Latest Deal</h5>
                  <p class="mb-0">Last 7 days</p>
                </div>
                <div>
                  <span
                    class="badge rounded-pill bg-success-subtle text-success border-success border text-end">86.5%</span>
                </div>
              </div>
              <div class="my-6 py-4">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0" id="minAmount">0đ</h5>
                    <h6 class="mb-0" id="maxAmount">0đ</h6>
                </div>
                <div class="progress bg-light-subtle w-100 my-2">
                    <div class="progress-bar text-bg-primary" role="progressbar" aria-label="Ticket Amount Progress"
                        style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="ticketAmountProgressBar"></div>
                </div>
                <p class="mb-0 voucherUsageData">Vouchers used: 0/0</p>
              </div>
              <h6 class="mb-7">Recent Purchasers</h6>
              <ul class="hstack mb-0"></ul>
            </div>
          </div>

        </div>
        <div class="col-sm-6 d-flex align-items-stretch">
          <div class="card w-100">

            <div class="card-body">
              <div class="d-flex justify-content-between">
                  <div>
                      <h5 class="card-title mb-1">Customers</h5>
                      <p class="mb-0">Last 7 days</p>
                  </div>
                  <div>
                      <h5 class="card-title mb-1 text-end">6,380</h5>
                      <span class="badge rounded-pill bg-success-subtle text-success border-success border text-end">+26.5%</span>
                  </div>
              </div>
              <div id="customers" class="my-5"></div>
              <div class="d-flex align-items-center justify-content-between mb-2">
                  <p class="mb-0">April 07 - April 14</p>
                  <p class="mb-0">6,380</p>
              </div>
              <div class="d-flex align-items-center justify-content-between">
                  <p class="mb-0">Last Week</p>
                  <p class="mb-0">4,298</p>
              </div>
          </div>

          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-8 d-flex align-items-stretch">
      <div class="card w-100">

        
        <div class="card-body">
          <div class="table-responsive overflow-x-auto products-tabel8">
            <table class="table text-nowrap customize-table mb-0 align-middle">
              <thead class="text-dark fs-4">
                <tr>
                  <th>Products</th>
                  <th>Payment</th>
                  <th>Status</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>


      </div>
    </div>
    <div class="col-lg-4 d-flex align-items-stretch">
      <div class="card w-100">
        
        <div class="card-body">
            <h5 class="card-title">Visit From Viet Nam</h5>
            <div id="vietnam" class="h-270"></div>
            <div id="cityStats" class="mt-4">
                <!-- Phần thống kê thành phố sẽ được thêm vào đây -->
            </div>
        </div>

      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card mb-0">

        <div class="card-body">
            <div class="d-md-flex justify-content-between mb-9">
                <div class="mb-9 mb-md-0">
                    <h5 class="card-title">Latest Detail Purchasers</h5>
                </div>
            </div>
            <div class="table-responsive overflow-x-auto latest-reviews-table1">
                <table class="table mb-0 align-middle text-nowrap">
                    <thead class="text-dark fs-4">
                        <tr>
                            <th>#</th>
                            <th>Movies</th>
                            <th>Customer</th>
                            <th>Price</th>
                            <th>Seat</th>
                            <th>Seat Type</th>
                            <th>Duration</th>
                            <th>Premiere Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        
      </div>
    </div>
  </div>
  @endif
@endsection