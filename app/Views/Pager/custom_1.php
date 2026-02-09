
<style>
.dropdown{
  margin-bottom:20px;
  width:100dvw;
  display:flex;
  justify-content:center;
  align-items:center;
}

.dropdown select, option{
  padding: 10px 15px;
  border-radius:5px;
}
</style>

<div class="dropdown">
  <select>
    {if $pager->getPageCount() > 1}
      {for $i=1 to $pager->getPageCount()}
        <option value='{$i}' {if $i == $pager->getCurrentpage()} selected {/if}> Page {$i}</option>
      {/endfor}
    {/if}
    <!-- <option>2</option>
    <option>3</option>
    <option>4</option> -->
  </select>
</div>

<!-- {if $pager->getPageCount() > 1}
{for $i=1 to $pager->getPageCount()}
<option value="{$i}" {if $i==$pager->getCurrentPage()} selected {/if}>Page {$i}</option>
{/for}
{/if} -->