async function submitData(e) {
  e.preventDefault();

  const feedback = $("#feedback");
  const newDiv = $("<div></div>");
  let isValid = true;

  const setBorder = (el, valid) => {
    el.css("border-color", valid ? "green" : "red");
    if (!valid) isValid = false;
  };

  const validateRequired = (el) => {
    const val = el.val().trim();
    el.val(val);
    setBorder(el, val !== "");
  };

  const validateRegex = (el, regex) => {
    setBorder(el, regex.test(el.val()));
  };

  const validateChecked = (selector) => {
    const checked = $(selector + ":checked").length > 0;
    $(selector).css("outline", checked ? "1px solid green" : "1px solid red");
    if (!checked) isValid = false;
  };

  const setError = (msg) => {
    feedback.empty();
    newDiv.removeClass().addClass("alert alert-danger fade show").text(msg);
    feedback.append(newDiv);
  };

  const setSuccess = (msg) => {
    feedback.empty();
    newDiv.removeClass().addClass("alert alert-success fade show").text(msg);
    feedback.append(newDiv);
  };

  $("#formId [required]").each(function () {
    if (this.type !== "file") {
      validateRequired($(this));
    }
  });

  validateRegex(
    $("#email"),
    /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
  );
  validateRegex($("#mobileNumber"), /^[6-9]\d{9}$/);

  validateChecked("input[name='genderselect']");
  validateChecked("input[name='department[]']");

  setBorder($("#multiSelect"), !!$("#multiSelect").val());

  if (!isValid) {
    setError("All fields are required. Please check highlighted inputs.");
    return;
  }

  setSuccess("Validation successful");

  const convertToBase64 = (file) =>
    new Promise((resolve, reject) => {
      const reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onload = () => resolve(reader.result);
      reader.onerror = reject;
    });

  let base64Img = "";
  const fileInput = $("#studentPic")[0];
  if (fileInput.files.length) {
    base64Img = await convertToBase64(fileInput.files[0]);
  }

  const data = {
    studentRollNo: $("#rollno").val(),
    studentFirstName: $("#fname").val(),
    studentLastName: $("#lname").val(),
    fatherName: $("#fatherName").val(),
    dateOfBirth: $("#dateOfBirth").val(),
    mobileNumber: $("#mobileNumber").val(),
    email: $("#email").val(),
    password: $("#password").val(),
    gender: $("input[name='genderselect']:checked").val(),
    department: $("input[name='department[]']:checked")
      .map((_, el) => el.value)
      .get()
      .join(", "),
    course: $("#multiSelect").val(),
    studentPic: base64Img,
    old_file: $("input[name='old_file']").val() || null,
    city: $("#city").val(),
    address: $("#address").val(),
  };

  const editId = $("#edit_id").val();
  if (editId) data.editId = editId;

  $.ajax({
    url: base_url + "studentform/save-items",
    method: "POST",
    contentType: "application/json",
    data: JSON.stringify(data),
    success: (res) => {
      setSuccess(res.message);
      setTimeout(() => {
        window.location.href = base_url + "studentform/display";
      }, 2000);
    },
    error: (err) => console.error(err),
  });
}

function importDataJS(e) {
  const fileInput = $("#excelFile");
  const file = fileInput[0].files[0];
  const validTypes = [
    "application/vnd.ms-excel",
    "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
  ];
  if (!validTypes.includes(file.type)) {
    alert("Please select a valid Excel file (.xls or .xlsx)");
    e.preventDefault();
    return false;
  } else {
    $("#importExcelForm").submit();
  }
}

function deleteOne(id, photoUrl) {
  var data = {};
  data.id = id;
  data.photoUrl = photoUrl;
  $.ajax({
    url: base_url + "studentform/delete-item",
    method: "POST",
    dataType: "json",
    data: data,
    success: function (res) {
      if (res.status == 1) {
        alert("Deleted Successfully");
        location.reload();
      }
    },
    error: function (err) {
      alert("Not Deleted: " + err.responseText);
    },
  });
}

function sampleExport() {
  console.log("sample clicked");
  $.ajax({
    url: base_url + "insertData/sample-excel",
    type: "POST",
    xhrFields: {
      responseType: "blob",
    },
    success: function (blob) {
      const url = window.URL.createObjectURL(blob);
      var aTag = $("<a></a>");
      $("body").append(aTag);
      aTag.attr("href", url);
      aTag.attr("download", "sample-excel.xlsx");
      aTag[0].click();
      aTag.remove();

      window.URL.revokeObjectURL(url);
    },
  });
}

function exportDataJS() {
  console.log("Export button clicked");

  $.ajax({
    url: base_url + "insertData/export-excel",
    type: "POST",
    xhrFields: {
      responseType: "blob",
    },
    success: function (blob) {
      const url = window.URL.createObjectURL(blob);
      var aTag = $("<a></a>");
      $("body").append(aTag);
      aTag.attr("href", url);
      aTag.attr("download", "students-data.xlsx");
      aTag[0].click();
      aTag.remove();

      window.URL.revokeObjectURL(url);
    },
  });
}

function deleteAllUsers() {
  var selectedIds = [];
  var data = {};
  $('table tbody input[type="checkbox"]:checked').each(function () {
    selectedIds.push($(this).val());
  });

  if (selectedIds.length === 0) {
    alert("No users selected for deletion.");
    return;
  }

  data.ids = selectedIds;

  if (confirm("Are you sure you want to delete the selected users?")) {
    $.ajax({
      url: base_url + "insertData/delete-multiple",
      type: "POST",
      data: data,
      success: function (res) {
        if (res.status == 1) {
          alert("Selected users deleted successfully.");
          location.href = base_url + "insertData/display";
        } else {
          alert("Error deleting users: " + res.message);
        }
      },
      error: function (err) {
        alert("Error deleting users: " + err.responseText);
      },
    });
  }
}

$(document).ready(() => {
  setTimeout(function () {
      $(".myAlert")
        .fadeTo(500, 0)
        .slideUp(500, function () {
          $(this).remove();
        });
    }, 1500);

  $("#mobileNumber").keydown(function (e) {
    var key = e.keyCode;
    if (!((key >= 48 && key <= 57) || key == 8 || key == 37 || key == 39)) {
      e.preventDefault();
    }
  });

  $("#multiselect").on("click", function () {
    var isChecked = $(this).is(":checked");
    $('table tbody input[type="checkbox"]').each(function () {
      $(this).prop("checked", isChecked);
    });
  });

  $("#studentPic").on("change", function () {
    onChangeImage(this);
  });
  function onChangeImage(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $("#preview").attr("src", e.target.result).show();
      };
      reader.readAsDataURL(input.files[0]);
    }
  }

  $("#studentPic").on("change", function () {
    if (this.files && this.files[0]) {
      const reader = new FileReader();
      reader.onload = function (e) {
        $("#preview").attr("src", e.target.result).show();
        $(".customBtn").show();

        $(".customBtn").on("click", function () {
          $("#preview").hide();
          $(".customBtn").hide();
          $("#studentPic").val("");
          $("#old_file").val("");
        });
      };
      reader.readAsDataURL(this.files[0]);
    }
  });

  $(".customEyeBtn").on("mouseover", function () {
    $("#password").attr("type", "text");
  });
  $(".customEyeBtn").on("mouseleave", function () {
    $("#password").attr("type", "password");
  });
});
