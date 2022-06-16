function fetchdata(hospital_name) {
  fetch(
    "https://covid19-api-philippines.herokuapp.com/api/facilities/summary?region=region%20iii%3A%20central%20luzon&hospital_name=" +
      hospital_name
  )
    .then((result) => result.json())
    .then((json) => {
      if (hospital_name == "n/a") {
        document.getElementById("status").className =
          "fa fa-question-circle text-primary h5 ml-auto";
        document.getElementById("status").title = "No hospital fetched.";
        document.getElementById("status2").className =
          "fa fa-question-circle text-primary h5 ml-auto";
        document.getElementById("status2").title = "No hospital fetcehd.";
      } else if (json.data.hospital_name == hospital_name) {
        var occupancy_rate;
        var total_beds;
        var vacant_beds;
        var occupied_beds;

        var mechvent_ot;
        var mechvent_vt;
        var mechvent_onc;
        var mechvent_vnc;

        // var cv_icu_o;
        // var cv_isol_o;
        // var cv_ward_o;
        // var cv_icu_v;
        // var cv_isol_v;
        // var cv_ward_v;

        // var nc_icu_o;
        // var nc_isol_o;
        // var nc_ward_o;
        // var nc_icu_v;
        // var nc_isol_v;
        // var nc_ward_v;

        occupancy_rate = json.data.occupancy_rate * 100;
        total_beds =
          json.data.beds.total_vacant + json.data.beds.total_occupied;
        vacant_beds = json.data.beds.total_vacant;
        occupied_beds = json.data.beds.total_occupied;

        mechvent_ot = json.data.equipments.mechvent_v;
        mechvent_vt = json.data.equipments.mechvent_o;
        mechvent_onc = json.data.equipments.mechvent_v_nc;
        mechvent_vnc = json.data.equipments.mechvent_o_nc;

        // cv_icu_o = json.data.beds.covid.icu_
        // cv_isol_o = json.data.beds.covid.icu_
        // cv_ward_o = json.data.beds.covid.isolbed_
        // cv_icu_v = json.data.beds.covid.isolbed_
        // cv_isol_v = json.data.beds.covid.
        // cv_ward_v = json.data.beds.covid.

        // nc_icu_o = json.data.beds.non_covid.icu_
        // nc_isol_o = json.data.beds.non_covid.icu_
        // nc_ward_o = json.data.beds.non_covid.isolbed_
        // nc_icu_v = json.data.beds.non_covid.isolbed_
        // nc_isol_v = json.data.beds.non_covid.
        // nc_ward_v = json.data.beds.non_covid.

        document.getElementById("occupancyrate").innerHTML =
          occupancy_rate + "%";
        document.getElementById("totalbeds").innerHTML = total_beds;
        document.getElementById("vacantbeds").innerHTML = vacant_beds;
        document.getElementById("occupiedbeds").innerHTML = occupied_beds;

        document.getElementById("mv_v").innerHTML = mechvent_vt;
        document.getElementById("mv_o").innerHTML = mechvent_ot;
        document.getElementById("mv_v_nc").innerHTML = mechvent_vnc;
        document.getElementById("mv_o_nc").innerHTML = mechvent_onc;

        document.getElementById("status").className =
          "fa fa-check-circle text-success h5 ml-auto mr-3";
        document.getElementById("status").title =
          "Data received successfully and is up to date.";
        document.getElementById("status2").className =
          "fa fa-check-circle text-success h5 ml-auto";
        document.getElementById("status2").title =
          "Data received successfully and is up to date.";

        $.ajax({
          type: "POST",
          url: "d072c492963735/add-patients.php",
          data: { number_of_patients: occupied_beds },
          dataType: "text",
          success: function (response) {},
        });
      } else {
        document.getElementById("status").className =
          "fa fa-exclamation-circle text-danger h5 ml-auto";
        document.getElementById("status").title =
          "Unable to retrieve information. The facility may not be functioning or has failed to submit data.";
        document.getElementById("status2").className =
          "fa fa-exclamation-circle text-danger h5 ml-auto";
        document.getElementById("status2").title =
          "Unable to retrieve information. The facility may not be functioning or has failed to submit data.";
      }
    });
}

fetchdata(
  String(document.getElementById("hospital_name").innerHTML).toLowerCase()
);
