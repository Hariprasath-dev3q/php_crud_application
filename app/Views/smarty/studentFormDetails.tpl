<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Display Student Table</title>

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

    .pagination-wrapper {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }

    .page-btn {
      padding: 10px 16px;
      margin: 0 4px;
      border: 1px solid #ddd;
      text-decoration: none;
      color: #333;
      border-radius: 6px;
      background: #f8f8f8;
      transition: 0.2s;
    }

    .page-btn:hover {
      background: #e2e2e2;
    }

    .page-btn.active {
      background: #cfd3db;
      font-weight: bold;
    }

    .dots {
      padding: 10px 12px;
    }
  </style>
</head>

<body>
  <div class="container-fluid mt-3">
    <div class="col-md-12 mb-3 d-flex justify-content-between">

      <div class="d-flex justify-content-start">

        <form method="post" enctype="multipart/form-data" action="{$base_url}insertData/import-excel"
          id="importExcelForm">
          <label class="file-btn btn btn-warning mb-3 ms-3 text-white">
            Import <i class="fa-solid fa-file-import"></i>
            <input type="file" id="excelFile" name="excelFile" accept=".xls,.xlsx" style="display: none;"
              onchange=" if(confirm('Are you sure you want to import this file?')) return importDataJS(event)" />
          </label>
        </form>
        <button class="btn btn-success mb-3 ms-3 text-decoration-none text-white" onclick='exportDataJS()'>Export <i
            class="fas fa-file-excel"></i>
        </button>
        <button class="btn btn-danger mb-3 ms-3" onclick="deleteAllUsers()">Delete <i class="fa-solid fa-trash"></i>
        </button>
        <button class="btn btn-primary mb-3 ms-3 text-decoration-none text-white" onclick="sampleExport()">
          Sample Excel <i class="fa-solid fa-file-lines"></i>
        </button>
      </div>
      <div class="d-flex justify-content-end w-50">
        {if $error}
          <div class="alert alert-danger alert-dismissible fade show myAlert w-50" role="alert">
            {$error}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        {/if}
        {if $success}
          <div class="alert alert-success alert-dismissible fade show myAlert w-50" role="alert">
            {$success}
            <button type="button" class="btn-close my-alert-height" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        {/if}
      </div>
    </div>

    <table class="table border border-dark table-responsive">
      <thead class="table-success text-nowrap">
        <tr class="">
          <th scope="col"><input type="checkbox" id="multiselect" /></th>
          <th scope="col">S.No</th>
          <th scope="col">ROLL NO</th>
          <th scope="col">USER NAME</th>
          <th scope="col">FATHER</th>
          <th scope="col">DOB</th>
          <th scope="col">MOBILE</th>
          <th scope="col">EMAIL</th>
          <th scope="col">PASSWORD</th>
          <th scope="col">GENDER</th>
          <th scope="col">DEPARTMENT</th>
          <th scope="col">COURSE</th>
          <th scope="col">CITY</th>
          <th scope="col">ADDRESS</th>
        </tr>
      </thead>
      <tbody class="text-nowrap">
        {if empty($items)}
          <tr>
            <td colspan="15" class="text-center">{$no_data}</td>
          </tr>
        {else}

          {assign var="itemsPerPage" value=50}
          {assign var="count" value=($currentPage - 1) * $itemsPerPage + 1}


          {foreach $items as $item}
            <tr>
              <td><input type="checkbox" value="{$item.id}" /></td>
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
              <td>{$item.city}</td>
              <td>{$item.address}</td>
            </tr>

          {/foreach}
        {/if}
      </tbody>
    </table>

    {* Pagination Links
    <div class="pagination">
      {if isset($pager)}
        {$pager->links('default', 'custom')}
      {/if}
    </div> *}

    {if $totalPages > 1}
      <div class="pagination-wrapper">
        
        {if $currentPage > 1}
          <a class="page-btn" href="?page={$currentPage-1}">&#10094;</a>
        {/if}
        
        <a class="page-btn {if $currentPage == 1}active{/if}" href="?page=1">1</a>

        {if $currentPage > 4}
          <span class="dots">...</span>
        {/if}

        {for $i=$currentPage-1 to $currentPage+1}
          {if $i > 1 && $i < $totalPages}
            <a class="page-btn {if $i == $currentPage}active{/if}" href="?page={$i}">{$i}</a>
          {/if}
        {/for}

        {if $currentPage < $totalPages-3}
          <span class="dots">...</span>
        {/if}

        {if $totalPages > 1}
          <a class="page-btn {if $currentPage == $totalPages}active{/if}" href="?page={$totalPages}">{$totalPages}</a>
        {/if}

        {if $currentPage < $totalPages}
          <a class="page-btn" href="?page={$currentPage+1}">&#10095;</a>
        {/if}

      </div>
    {/if}

</body>

</html>