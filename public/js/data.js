async function submitData(e) {
  e.preventDefault();
  var feedback = $("#feedback");
  var newDiv = $("<div></div>");

  var mobileNumber = $("#mobileNumber").val();
  var email = $("#email").val();
  var regexEmail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  var regexPhone = /^[6-9]\d{9}$/;
  var city = $("#city").val();
  var address = $("#address").val();

  var isValid = true;

  var inputs = $("#formId [required]");
  inputs.each(function () {
    if (this.type === "file") {
      return;
    }

    let value = $(this).val().trim();
    $(this).val(value);
    if (value === "") {
      $(this).css("border-color", "red");
      isValid = false;
    } else {
      $(this).css("border-color", "green");
    }
  });

  if (city.trim() === "") {
    $("#city").css("border-color", "red");
    isValid = false;
  } else {
    $("#city").css("border-color", "green");
  }
  if (address.trim() === "") {
    $("#address").css("border-color", "red");
    isValid = false;
  } else {
    $("#address").css("border-color", "green");
  }

  if (!regexEmail.test(email)) {
    $("#email").css("border-color", "red");
    isValid = false;
  } else {
    $("#email").css("border-color", "green");
  }

  //

  if (!regexPhone.test(mobileNumber)) {
    $("#mobileNumber").css("border-color", "red");
    isValid = false;
  } else {
    $("#mobileNumber").css("border-color", "green");
  }

  //Gender
  var genderOptions = $("input[name='genderselect']");
  const isGenderSelected = Array.from(genderOptions).some((r) => r.checked);
  if (!isGenderSelected) {
    $("input[name='genderselect']").css("outline", "1px solid red");
    isValid = false;
  } else {
    $("input[name='genderselect']").css("outline", "1px solid green");
  }

  //Department
  var deptOptionsChecked = $('input[type="checkbox"]:checked');
  if (deptOptionsChecked.length == 0) {
    $('input[type="checkbox"]').css("outline", "1px solid red");
    isValid = false;
  } else {
    $('input[type="checkbox"]').css("outline", "1px solid green");
  }

  var course_selection = $('select[name="course_selection"]');
  if (!course_selection.val()) {
    course_selection.css("border-color", "red");
    isValid = false;
  } else {
    course_selection.css("border-color", "green");
  }

  function setError() {
    feedback.empty();
    newDiv.addClass("alert alert-danger fade show");
    newDiv.text("All Fields Are Required Please Enter!");
    feedback.append(newDiv);
  }

  function setSuccess(msg) {
    feedback.empty();
    newDiv.removeClass("alert alert-danger fade show");
    newDiv.addClass("alert alert-success fade show");
    newDiv.text(msg);
    feedback.append(newDiv);
    return;
  }

  if (!isValid) {
    setError();
    return;
  } else {
    setSuccess();
  }
  function convertToBase64(file) {
    return new Promise((resolve, reject) => {
      const reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onload = () => resolve(reader.result);
      reader.onerror = reject;
    });
  }
  var base64Img = "";
  if ($("#studentPic")[0].files.length !== 0) {
    try {
      base64Img = await convertToBase64($("#studentPic")[0].files[0]);
    } catch (error) {
      alert("Error converting image");
    }
  }

  var data = {
    studentRollNo: $("#rollno").val(),
    studentFirstName: $("#fname").val(),
    studentLastName: $("#lname").val(),
    fatherName: $("#fatherName").val(),
    dateOfBirth: $("#dateOfBirth").val(),
    mobileNumber: $("#mobileNumber").val(),
    email: $("#email").val(),
    password: $("#password").val(),
    gender: $('input[name="genderselect"]:checked').val(),
    department: Array.from($('input[name="department[]"]:checked'))
      .map((cb) => cb.value)
      .join(", "),
    course: $("#multiSelect").val(),
    studentPic: base64Img,
    old_file: $("input[name='old_file']").val() || null,
    city: $("#city").val(),
    address: $("#address").val(),
  };

  const editIdElement = $("#edit_id");
  if (editIdElement && editIdElement.val()) {
    data.editId = editIdElement.val();
  }

  $.ajax({
    url: base_url + "home/save-items",
    method: "POST",
    dataType: "json",
    contentType: "application/json",
    data: JSON.stringify(data),
    success: function (result) {
      console.log(result);
      setSuccess(result.message);
      setTimeout(() => {
        window.location.href = base_url + "home/display";
      }, 2000);
      return;
    },
    error: function (error) {
      console.log("Error fired" + error);
    },
  });
}

function deleteOne(id, photoUrl) {
  //console.log("object");
  var data = {};
  data.id = id;
  data.photoUrl = photoUrl;
  $.ajax({
    url: base_url + "home/delete-item",
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

function exportDataJS(
 
) {
  console.log("Export button clicked");

  $.ajax({
    url: base_url + "export-excel",
    type: "POST",
    xhrFields: {
      responseType: "blob",
    },
    // dataType: "json",
    // contentType: "application/json",
    // data: JSON.stringify(data),
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

$(document).ready(() => {
  $("#mobileNumber").keydown(function (e) {
    var key = e.keyCode;
    if (!((key >= 48 && key <= 57) || key == 8 || key == 37 || key == 39)) {
      e.preventDefault();
    }
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
