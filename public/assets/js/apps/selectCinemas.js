document.getElementById('city-select').addEventListener('change', function () {
    var cityId = this.value;
    var cinemaSelect = document.getElementById('cinemaSelect');
    cinemaSelect.innerHTML = '<option value="">select cinema</option>';
    cinemaSelect.disabled = false;
    if (cityId) {
        fetch('/admin/cinema/city/' + cityId)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    data.forEach(function (cinema) {
                        var option = document.createElement('option');
                        option.value = cinema.id;
                        option.text = cinema.name;
                        cinemaSelect.add(option);
                    });
                    cinemaSelect.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error fetching cinemas:', error);
            });
    }
});