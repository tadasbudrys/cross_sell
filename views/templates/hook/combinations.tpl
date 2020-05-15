{$product_id}
  <br>

  <table>
  <tr><th>&nbsp;</th><th>Atributo nr.</th><th>atributas</th><th>Produkto nr</th></tr>
  {section name=co loop=$atributes}
  <form action="" method="POST" id="comment-form">
   <tr>
     <td><button type="submit" name="delete_atribute"class="button btn btn-default button-medium">Istrinti atributa
         <button type="submit" name="update_atribute"class="button btn btn-default button-medium">Prideti atributa
     </td>
     <td><option name="id" id="id" class="form-control">{$atributes[co].id}</option></td>
     <td><optionoption name="id_attribute" id="order" class="form-control"></option>

     <select name="attribute[]">
      {foreach $atributes_list as $attribute }
         <option value="{$attribute.id}">{$attribute.name}</option>
      {/foreach}     </select>
     </td>
     <td><option name="id_product" id="visibe" class="form-control">{$atributes[co].id_product}</option></td>
     <!-- <td>{$atributes[co].name} -->
   <tr>
     </button>
     </button>
   </form>
  {sectionelse}
   <tr><td colspan="5">No items found</td></tr>
  {/section}
  </table>

  <p>

  </p>
