<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Display Table</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
  </script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
    integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script>
    var base_url='{$base_url}';
  </script>
  <script src="{$base_url}js/student-form.js"></script>

  <style>
    .custom-edit-icon {
      color: black;
    }

    .custom-del-icon {
      color: red;
    }

    th,
    td {
      border: 1px solid black !important;
    }

    img {
      width: 150px;
    }

    .pagination {
      margin-top: 20px;

    }
  </style>
</head>

<body>
  <div class="container-fluid mt-3">
    
    <div class="col-md-12 mb-3 d-flex justify-content-between">
      <div class="d-flex justify-content-start">
        <a href="{$addUserUrl}" class="btn btn-primary mb-3 text-decoration-none text-white">Add User</a>

        {* <a href="javascript:void(0);" class="btn btn-success mb-3 ms-3 text-decoration-none text-white"
          onclick='exportDataJS()'>Export <i class="fas fa-file-excel"></i></a>
        <form method="post" enctype="multipart/form-data" action="{$base_url}insertData/import-excel" id="importExcelForm">
          <label class="file-btn btn btn-warning mb-3 ms-3 text-white">
            Import <i class="fa-solid fa-file-import"></i>
            <input type="file" id="excelFile" name="excelFile" accept=".xls,.xlsx" style="display: none;"
              onchange=" if(confirm('Are you sure you want to import this file?')) return importDataJS(event)" />
          </label>
        </form>
        <button class="btn btn-danger mb-3 ms-3" onclick="deleteAllUsers()">DeleteAll</button> *}
      </div>
      
      </div>
    </div>

    <table class="table border border-dark table-responsive">
      <thead class="table-success text-nowrap">
        <tr class="">
          {* <th scope="col"><input type="checkbox" id="multiselect" /></th> *}
          <th scope="col">S.No</th>
          <th scope="col">Roll.No</th>
          <th scope="col">UserName</th>
          <th scope="col">Father</th>
          <th scope="col">DOB</th>
          <th scope="col">Mobile</th>
          <th scope="col">Email</th>
          <th scope="col">Password</th>
          <th scope="col">Gender</th>
          <th scope="col">Department</th>
          <th scope="col">Course</th>
          <th scope="col">File</th>
          <th scope="col">City</th>
          <th scope="col">Address</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody class="text-nowrap">
        {if empty($items)}
          <tr>
            <td colspan="15" class="text-center">{$no_data}</td>
          </tr>
        {else}
          {assign var="itemsPerPage" value=50}
          {assign var="currentPage" value=$pager->getCurrentPage()}
          {assign var="count" value=($currentPage - 1) * $itemsPerPage + 1}
          {foreach $items as $item}
            <tr>
              {* <td><input type="checkbox" value="{$item.id}" /></td> *}
              <td>{$count++}</td>
              <td>{$item.rollNo}</td>
              <td>{$item.fname} {$item.lname}</td>
              <td>{$item.father_name}</td>
              <td>{$item.dob}</td>
              <td>{$item.mobile}</td>
              <td>{$item.email}</td>
              <td>{$item.password}</td>
              <td>{$item.gender}</td>
              <td>{$item.department}</td>
              <td>{$item.course}</td>
              <td><img src={$base_url}{$item.file} alt="item Image"></td>
              <td>{$item.city}</td>
              <td>{$item.address}</td>
              <td>
                <a href="{$editUrl}/{$item.id}" class="me-2"><i class="fa-solid fa-pen-to-square custom-edit-icon"></i></a>
                <a href="javascript:void(0);" onclick="deleteOne('{$item.id}','{$item.file}')"><i
                    class="fa-solid fa-trash custom-del-icon"></i></a>
              </td>
            </tr>

          {/foreach}
        {/if}
      </tbody>
    </table>

    {* Pagination Links *}
    <div class="pagination">
      {if isset($pager)}
        {$pager->links('default', 'custom')}
      {/if}
    </div>

</body>

</html>