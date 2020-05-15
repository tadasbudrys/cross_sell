<table>
<tr><th>order</th><th>visible</th></tr>
 <h3 class="page-product-heading">Kategorijos sukurimas </h3>
<form action="" method="POST" id="comment-form">

  <button type="submit" name="kategorijos"class="button btn btn-default button-medium">Save
<!-- <label for="comment">order:</label> -->
<td><input name="order" id="order" class="form-control"></input></td>
<!-- <label for="comment">visible:</label> -->
<td><input name="visibe" id="visibe" class="form-control"></input></td>
</button>

</form>
</tr>
</table>

<br>
<table>
<h3 class="page-product-heading">Kategorijos pavadinimo sukurimas </h3>
<tr><th>id_lang</th><th>id_cattegory nr.</th><th>name</th></tr>
<form action="" method="POST" id="comment-form">
  <button type="submit" name="kategorija"class="button btn btn-default button-medium">Save

<!-- <label for="comment">id_lang:</label> -->
<td><input name="id_lang" id="id_lang" class="form-control"></input></td>
<!-- <label for="comment">id_cattegory:</label> -->
<td><input name="id_cattegory" id="id_cattegory" class="form-control"></input></td></td>
<!-- <label for="comment">name:</label> -->
<td><input name="name" id="name" class="form-control"></input></td>

  </button>
</form>
</table>
<br>

<table>
<h3 class="page-product-heading">Atriutu sukurimas </h3>
<tr><th>Atributo nr</th><th>Produkto nr </th></tr>
<form action="" method="POST" id="comment-form">
  <button type="submit" name="atributas"class="button btn btn-default button-medium">Save

<!-- <label for="comment">id_attribute:</label> -->
<td><input name="id_attribute" id="id_attribute" class="form-control"></input></td>
<!-- <label for="comment">id_product:</label> -->
<td><input name="id_product" id="id_product" class="form-control"></input></td>

</button>
</form>
</table>

<br>

<table>
<h3 class="page-product-heading">ps_compatibility_attributes </h3>
<tr><th>id_category</th></tr>
<form action="" method="POST" id="comment-form">
<button type="submit" name="compatibility_attributes"class="button btn btn-default button-medium">Save

<!-- <label for="comment">id_category:</label> -->
<td><input name="id_category" id="id_category" class="form-control"></input></td>

<div class="submit">
  </button>
</form>
</table>

<br>
<br>
<table>
<tr><th>&nbsp;</th><th>id></th><th>id_lang</th><th>id_cattegory</th><th>name</th></tr>
{section name=co loop=$contacts}
<form action="" method="POST" id="comment-form">
  <tr>
    <td><button type="submit" name="delete_lang"class="button btn btn-default button-medium">delete</button>
        <button type="submit" name="update_lang"class="button btn btn-default button-medium">update</button>
    </td>
    <td><textarea name="id" id="id" class="form-control">{$contacts[co].id}</textarea></td>
    <td><textarea name="id_lang" id="id_lang" class="form-control">{$contacts[co].id_lang}</textarea></td>
    <td><textarea name="id_cattegory" id="id_cattegory" class="form-control">{$contacts[co].id_cattegory}</textarea></td>
    <td><textarea name="name" id="name" class="form-control">{$contacts[co].name}</textarea></td>
  <tr>
    </button>
  </form>
{sectionelse}
  <tr><td colspan="5">No items found</td></tr>
{/section}
</table>
<br>
<table>
<tr><th>&nbsp;</th><th>id></th><th>order</th><th>visible</th></tr>
{section name=co loop=$compatibility}
<form action="" method="POST" id="comment-form">
  <tr>
    <td><button type="submit" name="delete"class="button btn btn-default button-medium">delete</button>
        <button type="submit" name="update"class="button btn btn-default button-medium">update</button>
    </td>
    <td><textarea name="id" id="id" class="form-control">{$compatibility[co].id}</textarea></td>
    <td><textarea name="order" id="order" class="form-control">{$compatibility[co].order}</textarea></td>
    <td><textarea name="visibe" id="visibe" class="form-control">{$compatibility[co].visibe}</textarea></td>
  <tr>
    </button>
  </form>
{sectionelse}
  <tr><td colspan="5">No items found</td></tr>
{/section}
</table>

<br>

<table>
<tr><th>&nbsp;</th><th>id></th><th>id_attribute</th><th>id_product</th></tr>
{section name=co loop=$atributes}
<form action="" method="POST" id="comment-form">
  <tr>
    <td><button type="submit" name="delete_atribute"class="button btn btn-default button-medium">delete</button>
        <button type="submit" name="update_atribute"class="button btn btn-default button-medium">update</button>
    </td>
    <td><textarea name="id" id="id" class="form-control">{$atributes[co].id}</textarea></td>
    <td><textarea name="id_attribute" id="order" class="form-control">{$atributes[co].id_attribute}</textarea></td>
    <td><textarea name="id_product" id="visibe" class="form-control">{$atributes[co].id_product}</textarea></td>
  <tr>
    </button>
  </form>
{sectionelse}
  <!-- <tr><td colspan="5">No items found</td></tr> -->
{/section}
</table>

<br>

<table>
<tr><th>&nbsp;</th><th>id></th><th>id_category</th></tr>
{section name=co loop=$atributes_list}
<form action="" method="POST" id="comment-form">
  <tr>
    <td><button type="submit" name="delete_compatibility_attributes"class="button btn btn-default button-medium">delete</button>
        <button type="submit" name="compatibility_attributes"class="button btn btn-default button-medium">update</button>
    </td>
    <td><textarea name="id" id="id" class="form-control">{$atributes_list[co].id}</textarea></td>
    <td><textarea name="id_category" id="visibe" class="form-control">{$atributes_list[co].id_category}</textarea></td>
  <tr>
    </button>
  </form>
{sectionelse}
  <!-- <tr><td colspan="5">No items found</td></tr> -->
{/section}
</table>
