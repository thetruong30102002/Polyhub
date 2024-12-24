$(function () {
    // =====================================
    // netsells chart
    // =====================================
    $("#timeframe-select").on("change", function () {
        var selectedOption = $(this).val();
        var url;

        switch (selectedOption) {
            case "1":
                url =
                    "http://127.0.0.1:8000/api/admin/ticket-movie-data?timeframe=day";
                break;
            case "2":
                url =
                    "http://127.0.0.1:8000/api/admin/ticket-movie-data?timeframe=week";
                break;
            case "3":
                url =
                    "http://127.0.0.1:8000/api/admin/ticket-movie-data?timeframe=month";
                break;
            case "4":
                url =
                    "http://127.0.0.1:8000/api/admin/ticket-movie-data?timeframe=year";
                break;
        }

        $.ajax({
            url: url,
            method: "GET",
            success: function (response) {
                const dates = response.map((item) => item.date);
                const soldTickets = response.map((item) => item.sold_tickets);

                var netsells = {
                    series: [
                        {
                            name: "Tickets Sold",
                            data: soldTickets,
                        },
                    ],
                    chart: {
                        fontFamily: "inherit",
                        foreColor: "#adb0bb",
                        height: 260,
                        type: "line",
                        toolbar: {
                            show: false,
                        },
                        stacked: false,
                    },
                    legend: {
                        show: false,
                    },
                    stroke: {
                        width: 3,
                        curve: "smooth",
                    },
                    grid: {
                        borderColor: "var(--bs-border-color)",
                        xaxis: {
                            lines: {
                                show: true,
                            },
                        },
                        yaxis: {
                            lines: {
                                show: true,
                            },
                        },
                        padding: {
                            top: 0,
                            bottom: 0,
                            left: 0,
                            right: 0,
                        },
                    },
                    colors: ["#0085db", "#5AC8FA"],
                    fill: {
                        type: "gradient",
                        gradient: {
                            shade: "dark",
                            gradientToColors: ["#6993ff"],
                            shadeIntensity: 1,
                            type: "horizontal",
                            opacityFrom: 1,
                            opacityTo: 1,
                            stops: [0, 100, 100, 100],
                        },
                    },
                    markers: {
                        size: 0,
                    },
                    xaxis: {
                        labels: {
                            show: true,
                        },
                        type: "category",
                        categories: dates,
                        axisTicks: {
                            show: false,
                        },
                        axisBorder: {
                            show: false,
                        },
                    },
                    yaxis: {
                        axisTicks: {
                            show: false,
                        },
                        axisBorder: {
                            show: false,
                        },
                        labels: {
                            show: true,
                            formatter: function (value) {
                                return value + " tickets";
                            },
                        },
                    },
                    tooltip: {
                        theme: "dark",
                    },
                };
                new ApexCharts(
                    document.querySelector("#netsells"),
                    netsells
                ).render();
            },
            error: function (error) {
                console.error("Error fetching data:", error);
            },
        });
    });

    $("#timeframe-select").trigger("change");

    // =====================================
    // total-orders chart
    // =====================================

    $.ajax({
        url: "http://127.0.0.1:8000/api/admin/payment-methods-data",
        method: "GET",
        success: function (response) {
            if (response && response.length > 0) {
                const categories = response.map((item) => item.type);
                const totals = response.map((item) => item.total);
                const totalPayments = totals.reduce(
                    (sum, current) => sum + current,
                    0
                );

                // Cập nhật biểu đồ
                var total_orders = {
                    series: [
                        {
                            name: "Payments",
                            data: totals,
                        },
                    ],
                    chart: {
                        fontFamily: "inherit",
                        type: "bar",
                        height: 150,
                        stacked: true,
                        foreColor: "#707a82",
                        toolbar: {
                            show: false,
                        },
                    },
                    grid: {
                        show: false,
                        borderColor: "rgba(0,0,0,0.1)",
                        strokeDashArray: 1,
                        xaxis: {
                            lines: {
                                show: false,
                            },
                        },
                        yaxis: {
                            lines: {
                                show: true,
                            },
                        },
                        padding: {
                            top: 0,
                            right: 0,
                            bottom: 0,
                            left: 0,
                        },
                    },
                    colors: ["var(--bs-primary)", "#D9D9D9"],
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: "26%",
                            borderRadius: [3],
                            borderRadiusApplication: "end",
                            borderRadiusWhenStacked: "all",
                        },
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    xaxis: {
                        categories: categories,
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false,
                        },
                    },
                    yaxis: {
                        labels: {
                            show: false,
                        },
                    },
                    tooltip: {
                        theme: "dark",
                    },
                    legend: {
                        show: false,
                    },
                };

                // Render biểu đồ
                var chart_column_stacked = new ApexCharts(
                    document.querySelector("#total-orders"),
                    total_orders
                );
                chart_column_stacked.render();

                // Cập nhật số liệu
                let htmlContent = "";
                response.forEach((item) => {
                    const percentage = (
                        (item.total / totalPayments) *
                        100
                    ).toFixed(2);
                    let iconColor = getIconColor(item.type);
                    htmlContent += `
            <div class="d-flex align-items-center justify-content-between mb-2">
              <div class="d-flex align-items-center">
                <i class="ti ti-circle ${iconColor} fs-4 me-2"></i>
                <p class="mb-0">${item.type}</p>
              </div>
              <p class="mb-0">${percentage}%</p>
            </div>`;
                });
                $("#total-orders").append(htmlContent);
            } else {
                console.error("Empty or invalid response from API.");
            }
        },
        error: function (error) {
            console.error("Error fetching data:", error);
        },
    });

    function getIconColor(paymentType) {
        switch (paymentType) {
            case "paypal":
                return "text-primary";
            case "vnpay":
                return "text-success";
            case "momo":
                return "text-danger";
            default:
                return "text-secondary";
        }
    }

    // =====================================
    // products chart
    // =====================================

    $.ajax({
        url: "http://127.0.0.1:8000/api/admin/ticket-movie-data",
        method: "GET",
        success: function (response) {
            const dates = response.map((item) => item.date);
            const sold_tickets = response.map((item) => item.sold_tickets);

            var products = {
                chart: {
                    height: 170,
                    type: "donut",
                    fontFamily: "inherit",
                    foreColor: "#adb0bb",
                },
                series: sold_tickets,
                labels: dates,
                plotOptions: {
                    pie: {
                        startAngle: 0,
                        endAngle: 360,
                        donut: {
                            size: "85%",
                        },
                    },
                },
                stroke: {
                    show: false,
                },
                dataLabels: {
                    enabled: false,
                },
                legend: {
                    show: false,
                },
                colors: ["var(--bs-primary)", "#FB977D", "#5AC8FA"],
                tooltip: {
                    theme: "dark",
                    fillSeriesColor: false,
                },
            };

            // Tạo và render biểu đồ
            var chart = new ApexCharts(
                document.querySelector("#products"),
                products
            );
            chart.render();
        },
        error: function (error) {
            console.error("Error fetching data:", error);
        },
    });

    // =====================================
    // customers chart
    // =====================================

    fetch("http://127.0.0.1:8000/api/admin/customer-data")
        .then((response) => response.json())
        .then((data) => {
            // Chuyển đổi dữ liệu thành định dạng đồ thị
            const dates = data.map((item) => item.date);
            const clientCounts = data.map((item) => item.client_count);

            var options = {
                chart: {
                    id: "customers",
                    type: "area",
                    height: 103,
                    sparkline: {
                        enabled: true,
                    },
                    group: "sparklines",
                    fontFamily: "inherit",
                    foreColor: "#adb0bb",
                },
                series: [
                    {
                        name: "Clients",
                        color: "var(--bs-primary)",
                        data: clientCounts, // Dữ liệu từ API
                    },
                ],
                stroke: {
                    curve: "smooth",
                    width: 2,
                },
                fill: {
                    type: "gradient",
                    gradient: {
                        shadeIntensity: 0,
                        inverseColors: false,
                        opacityFrom: 0.05,
                        opacityTo: 0,
                        stops: [20, 180],
                    },
                },
                markers: {
                    size: 0,
                },
                tooltip: {
                    theme: "dark",
                    fixed: {
                        enabled: true,
                        position: "right",
                    },
                    x: {
                        show: false,
                    },
                },
            };
            new ApexCharts(
                document.querySelector("#customers"),
                options
            ).render();
        })
        .catch((error) => console.error("Error fetching data:", error));

    // -----------------------------------------------------------------------
    // world map
    // -----------------------------------------------------------------------
    $.getJSON(
        "http://127.0.0.1:8000/api/admin/client-locations",
        function (data) {
            var totalUsers = data.reduce((sum, city) => sum + city.count, 0);

            // Generate markers for the map
            var markers = data.map(function (city) {
                var percentage = (city.count / totalUsers) * 100;
                return {
                    latLng: [city.lat, city.lng], // Ensure lat & lng are in the data
                    name: `${city.city}: ${city.count}`,
                    style: { fill: getColorForPercentage(percentage) },
                };
            });

            // Initialize the vector map
            $("#vietnam").vectorMap({
                map: "vietnam",
                backgroundColor: "transparent",
                zoomOnScroll: false,
                regionStyle: {
                    initial: {
                        fill: "#c9d6de",
                    },
                },
                markers: markers,
            });

            // Update city statistics section
            var statsHtml = "";
            data.forEach(function (city) {
                var percentage = (city.count / totalUsers) * 100;
                statsHtml += `
                    <div class="hstack gap-4 mb-4">
                        <h6 class="mb-0 flex-shrink-0 w25">${city.city}</h6>
                        <div class="progress bg-light-subtle mt-1 w-100 h-5">
                            <div class="progress-bar text-bg-info" role="progressbar" style="width: ${percentage}%"
                                aria-valuenow="${percentage}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <h6 class="mb-0 flex-shrink-0 w35">${percentage.toFixed(
                            2
                        )}%</h6>
                    </div>
                `;
            });
            $("#cityStats").html(statsHtml);
        }
    );

    // Function to get color based on percentage
    function getColorForPercentage(percentage) {
        if (percentage >= 30) return "var(--bs-info)";
        if (percentage >= 20) return "var(--bs-primary)";
        if (percentage >= 10) return "var(--bs-danger)";
        return "var(--bs-light)";
    }

    // Function to determine color based on percentage
    function getColorForPercentage(percentage) {
        if (percentage > 25) return "var(--bs-info)";
        if (percentage > 20) return "var(--bs-primary)";
        if (percentage > 15) return "var(--bs-danger)";
        return "var(--bs-indigo)";
    }

    // -----------------------------------------------------------------------
    // progress bar
    // -----------------------------------------------------------------------
    fetch("http://127.0.0.1:8000/api/admin/ticket-amount-data")
        .then((response) => response.json())
        .then((data) => {
            document.getElementById("minAmount").textContent = `${Math.floor(
                data.min_amount
            ).toLocaleString()}đ`;
            document.getElementById("maxAmount").textContent = `${Math.floor(
                data.max_amount
            ).toLocaleString()}đ`;
            document.getElementById(
                "ticketAmountProgressBar"
            ).style.width = `${data.progress}%`;
            document.getElementById("ticketAmountProgressBar").ariaValueNow =
                data.progress;
        })
        .catch((error) => console.error("Error:", error));

    // -----------------------------------------------------------------------
    // Voucher Usage
    // -----------------------------------------------------------------------

    fetch("http://127.0.0.1:8000/api/admin/voucher-usage-data")
        .then((response) => response.json())
        .then((data) => {
            document.querySelector(
                ".voucherUsageData"
            ).textContent = `Voucher used: ${data.used}/${data.total}`;
        })
        .catch((error) => console.error("Error:", error));

    // -----------------------------------------------------------------------
    // Recent Purchasers
    // -----------------------------------------------------------------------

    fetch("http://127.0.0.1:8000/api/admin/recent-purchasers-data")
        .then((response) => response.json())
        .then((data) => {
            const purchasersList = document.querySelector(".hstack.mb-0");
            data.forEach((purchaser) => {
                const listItem = document.createElement("li");
                listItem.className = "ms-n2";

                const anchor = document.createElement("a");
                anchor.href = "javascript:void(0)";

                const img = document.createElement("img");
                img.src = `/storage/${purchaser.avatar}`;
                img.className = "rounded-circle border border-2 border-white";
                img.width = 40;
                img.height = 40;
                img.alt = purchaser.name;

                anchor.appendChild(img);
                listItem.appendChild(anchor);
                purchasersList.appendChild(listItem);
            });
        })
        .catch((error) => console.error("Error:", error));

    // -----------------------------------------------------------------------
    // Recent Order Detail
    // -----------------------------------------------------------------------

    $.getJSON("http://127.0.0.1:8000/api/admin/booked-movies", function (data) {
        var rows = data
            .map(function (movie) {
                return `
            <tr>
                <td class="ps-0">
                    <div class="form-check mb-0 flex-shrink-0">
                        <p>${movie.id}</p>
                    </div>
                </td>
                <td>
                    <div class="d-flex align-items-center product text-truncate">
                        <img src="${
                            movie.photo
                        }" class="img-fluid flex-shrink-0" width="60" height="60">
                        <div class="ms-3 product-title">
                            <h6 class="fs-4 mb-0 text-truncate-2">${
                                movie.name
                            }</h6>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="d-flex align-items-center text-truncate">
                        <img src="/storage/${
                            movie.customer_avatar
                        }" alt="" class="img-fluid rounded-circle flex-shrink-0" width="32" height="32">
                        <div class="ms-7">
                            <h5 class="mb-1 fs-4">${movie.customer_name}</h5>
                            <h6 class="mb-0 fw-light">${
                                movie.customer_email
                            }</h6>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="product-reviews">
                        <p class="text-dark mb-0 fw-normal text-truncate-2">${
                            movie.price
                        }</p>
                    </div>
                </td>
                <td>
                    <div class="product-reviews">
                        <p class="text-dark mb-0 fw-normal text-truncate-2">${movie.seatRow}${movie.seatColumn}</p>
                    </div>
                </td>
                <td>
                    <div class="product-reviews">
                        <p class="text-dark mb-0 fw-normal text-truncate-2">${movie.seatType}</p>
                    </div>
                </td>
                <td>
                    <span class="badge rounded-pill ${getStatusBadgeClass(
                        movie.duration
                    )}">${movie.duration}m</span>
                </td>
                <td>
                    <p class="mb-0">${new Date(
                        movie.premiere_date
                    ).toLocaleDateString()}</p>
                </td>
            </tr>
        `;
            })
            .join("");

        $(".latest-reviews-table1 tbody").html(rows);
    });

    function getStatusBadgeClass(status) {
      return "bg-success-subtle text-success border-success border";
    }

    // -----------------------------------------------------------------------
    // Best Movie Payment Method
    // -----------------------------------------------------------------------
    $.getJSON(
        "http://127.0.0.1:8000/api/admin/get-top-movies",
        function (data) {
            var tableBody = "";
            $.each(data, function (index, movie2) {
                tableBody += "<tr>";
                tableBody += '<td class="ps-0 border-bottom-0">';
                tableBody +=
                    '<div class="d-flex align-items-center product text-truncate">';
                tableBody +=
                    '<img src="/'+movie2.moviePhoto+'" class="img-fluid flex-shrink-0" width="60" height="60">';
                tableBody += '<div class="ms-3 product-title">';
                tableBody +=
                    '<h6 class="fs-4 mb-0 text-truncate-2">' +
                    movie2.movieName +
                    "</h6>";
                tableBody += "</div>";
                tableBody += "</div>";
                tableBody += "</td>";
                tableBody += '<td class="border-bottom-0">';
                tableBody +=
                    '<h5 class="mb-0 fs-4">' + movie2.paymentMethod + "</h5>";
                tableBody += '<div class="progress bg-light-subtle w-100 h-4">';
                tableBody +=
                    '<div class="progress-bar text-bg-success" role="progressbar" aria-label="Example 4px high" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>';
                tableBody += "</div>";
                tableBody += "</td>";
                tableBody += '<td class="border-bottom-0">';
                tableBody +=
                    '<span class="badge rounded-pill bg-success-subtle text-success border-success border">Confirmed</span>';
                tableBody += "</td>";
                tableBody += "</tr>";
            });
            $(".products-tabel8 tbody").html(tableBody);
        }
    ).fail(function () {
        alert("Error fetching data");
    });

});
