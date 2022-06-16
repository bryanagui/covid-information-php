$(document).ready(function () {
  $("[id='delete']").click(function (e) {
    var id = $(this).data("id");
    if (confirm("Are you sure you want to delete User ID " + id + "?")) {
      $.ajax({
        type: "POST",
        url: "d072c492963735/remove.php",
        data: { id: id },
        dataType: "json",
        success: function (response) {
          if (response.status == "forbidden") {
            alert("You are not allowed to do that!");
          } else if (response.status == "fail") {
            alert("Invalid UserID.");
            location.reload();
          } else {
            alert("Deleted UserID " + id + " successfully.");
            location.reload();
          }
        },
      });
    }
  });
  $("[id='edit']").click(function (e) {
    var id = $(this).data("id");
    $.ajax({
      type: "POST",
      url: "d072c492963735/edit_fetch.php",
      data: { id: id },
      dataType: "json",
      success: function (response) {
        if (response.status == "fail") {
          alert("Cannot find ID " + id + ". Did you change something?");
          $("#edit_firstname").val("");
          $("#edit_lastname").val("");
          $("#edit_email").val("");
          $("#edit_username").val("");
          $("#edit_roleid").val("");
          $("#edit_facility_id").val("");
          $("#submit-edit").prop("disabled", true);

          $("#edit_firstname").prop("disabled", true);
          $("#edit_lastname").prop("disabled", true);
          $("#edit_email").prop("disabled", true);
          $("#edit_username").prop("disabled", true);
          $("#edit_roleid").prop("disabled", true);
          $("#edit_facility_id").prop("disabled", true);
          location.reload();
        } else {
          $("#edit_firstname").val(response.firstname);
          $("#edit_lastname").val(response.lastname);
          $("#edit_email").val(response.email);
          $("#edit_username").val(response.username);
          $("#edit_roleid").val(response.roleid);
          $("#edit_facility_id").val(response.facilityid);
          $("#c0a84").val(id);
          $("#submit-edit").prop("disabled", false);
        }
      },
    });
  });
  $("[id='editForm']").submit(function (e) {
    var uid = $("input[name='c0a84']").val();
    var edit_firstname = $("input[id='edit_firstname']").val();
    var edit_lastname = $("input[id='edit_lastname']").val();
    var edit_email = $("input[id='edit_email']").val();
    var edit_username = $("input[id='edit_username']").val();
    var edit_roleid = $("input[id='edit_roleid']").val();
    var edit_facilityid = $("input[id='edit_facility_id']").val();
    if (confirm("Save changes on User ID " + uid + "?")) {
      $.ajax({
        type: "POST",
        url: "d072c492963735/edit_submit.php",
        data: {
          uid: uid,
          edit_firstname: edit_firstname,
          edit_lastname: edit_lastname,
          edit_email: edit_email,
          edit_username: edit_username,
          edit_roleid: edit_roleid,
          edit_facilityid: edit_facilityid,
        },
        dataType: "json",
        success: function (response) {
          if (response.status == "forbidden") {
            alert("You are nto allowed to do that!");
            location.reload();
          } else if (response.status == "fail") {
            alert("Failed to update.");
            location.reload();
          } else {
            alert("Saved changes successfully to User ID " + uid + ".");
            location.reload();
          }
        },
      });
    }
  });
});
