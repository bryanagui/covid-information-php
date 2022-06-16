$(document).ready(function () {
  fetch(
    "https://covid19-api-philippines.herokuapp.com/api/facilities/summary?region=region%20iii%3A%20central%20luzon&hospital_name=" +
      $("#facility-name").html()
  )
    .then((result) => result.json())
    .then((json) => {
      if ($("#facility-name").html() == "n/a") {
      } else if (json.data.hospital_name == $("#facility-name").html()) {
        var total_occupied_beds = json.data.beds.total_occupied;
        $("#occupied-beds").html(total_occupied_beds);
        $("#vacant-beds").html(json.data.beds.total_vacant);
        $("#total-beds").html(
          json.data.beds.total_occupied + json.data.beds.total_vacant
        );

        $("#occupied-beds").attr("data-occ", json.data.beds.total_occupied);
        $("#vacant-beds").attr("data-vac", json.data.beds.total_occupied);
        $("#total-beds").attr(
          "data-tot",
          json.data.beds.total_occupied + json.data.beds.total_vacant
        );
      } else {
      }
    });
  $("#admissions").DataTable();
  $("#releases").DataTable();
});
