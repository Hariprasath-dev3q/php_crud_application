{* Partial template - table and pagination only *}
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
      {assign var="itemsPerPage" value=20}
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

{if $totalPages > 1}
  <div class="pagination-wrapper">
    {if $currentPage > 1}
      <a class="page-btn ajax-page" data-index="{$currentPage-1}" href="javascript:void(0)">&#10094;</a>
    {/if}

    <a class="page-btn ajax-page {if $currentPage == 1}active{/if}" data-index="1" href="javascript:void(0)">1</a>

    {if $currentPage > 4}
      <span class="dots">...</span>
    {/if}

    {for $i=$currentPage-1 to $currentPage+1}
      {if $i > 1 && $i < $totalPages}
        <a class="page-btn ajax-page {if $i == $currentPage}active{/if}" data-index="{$i}" href="javascript:void(0)">{$i}</a>
      {/if}
    {/for}

    {if $currentPage < $totalPages-3}
      <span class="dots">...</span>
    {/if}

    {if $totalPages > 1}
      <a class="page-btn ajax-page {if $currentPage == $totalPages}active{/if}" data-index="{$totalPages}"
        href="javascript:void(0)">{$totalPages}</a>
    {/if}

    {if $currentPage < $totalPages}
      <a class="page-btn ajax-page" data-index="{$currentPage+1}" href="javascript:void(0)">&#10095;</a>
    {/if}
  </div>
{/if}