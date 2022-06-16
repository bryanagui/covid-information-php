$(document).ready(function () {
  function sum(obj) {
    var sum = 0;
    for (var el in obj) {
      if (obj.hasOwnProperty(el)) {
        sum += parseFloat(obj[el]);
      }
    }
    return sum;
  }

  fetch("https://covid19-api-philippines.herokuapp.com/api/facilities")
    .then((result) => result.json())
    .then((json) => {
      //   console.log(json.data.filter((v) => v.province === "bulacan"));
      var dataArr = [json.data.filter((x) => x.province === "bulacan")];
      var patient_sus = {
        asymptomatic: 0,
        mild: 0,
        severe: 0,
        died: 0,
      };
      var patient_prob = {
        asymptomatic: 0,
        mild: 0,
        severe: 0,
        died: 0,
      };
      var patient_conf = {
        asymptomatic: 0,
        mild: 0,
        severe: 0,
        died: 0,
      };
      var facility_beds = {
        icu_o: 0,
        isolbed_o: 0,
        beds_ward_o: 0,
        icu_v: 0,
        isolbed_v: 0,
        beds_ward_v: 0,
      };
      for (var i = 0; i < 60; i++) {
        patient_sus.asymptomatic += dataArr[0][i].susp_asym;
        patient_sus.mild += dataArr[0][i].susp_mild;
        patient_sus.severe += dataArr[0][i].susp_severe;
        patient_sus.died += dataArr[0][i].susp_died;
        patient_prob.asymptomatic += dataArr[0][i].prob_asym;
        patient_prob.mild += dataArr[0][i].prob_mild;
        patient_prob.severe += dataArr[0][i].prob_severe;
        patient_prob.died += dataArr[0][i].prob_died;
        patient_conf.asymptomatic += dataArr[0][i].conf_asym;
        patient_conf.mild += dataArr[0][i].conf_mild;
        patient_conf.severe += dataArr[0][i].conf_severe;
        patient_conf.died += dataArr[0][i].conf_died;

        facility_beds.icu_o += dataArr[0][i].icu_o;
        facility_beds.isolbed_o += dataArr[0][i].isolbed_o;
        facility_beds.beds_ward_o += dataArr[0][i].beds_ward_o;
        facility_beds.icu_v += dataArr[0][i].icu_v;
        facility_beds.isolbed_v += dataArr[0][i].isolbed_v;
        facility_beds.beds_ward_v += dataArr[0][i].beds_ward_v;
      }
      $("#sus_asym").text(patient_sus.asymptomatic);
      $("#sus_mild").text(patient_sus.mild);
      $("#sus_severe").text(patient_sus.severe);
      $("#sus_death").text(patient_sus.died);
      $("#prob_asym").text(patient_prob.asymptomatic);
      $("#prob_mild").text(patient_prob.mild);
      $("#prob_severe").text(patient_prob.severe);
      $("#prob_death").text(patient_prob.died);
      $("#conf_asym").text(patient_conf.asymptomatic);
      $("#conf_mild").text(patient_conf.mild);
      $("#conf_severe").text(patient_conf.severe);
      $("#conf_death").text(patient_conf.died);

      $("#icu_o").text(facility_beds.icu_o);
      $("#isolbed_o").text(facility_beds.isolbed_o);
      $("#beds_ward_o").text(facility_beds.beds_ward_o);
      $("#icu_v").text(facility_beds.icu_v);
      $("#isolbed_v").text(facility_beds.isolbed_v);
      $("#beds_ward_v").text(facility_beds.beds_ward_v);
    });
});
