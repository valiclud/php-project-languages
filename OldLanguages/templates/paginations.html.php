<table>
<tr>
    <th>Id</th>
    <th>Controller Name</th>
    <th>Records per Page</th>
  </tr>
<?php foreach ($paginations as $page): ?>
  <tr>
  <?php 
  echo "<td>".htmlspecialchars($page->id, ENT_QUOTES, 'UTF-8')."</td>"
  ."<td>".htmlspecialchars($page->controller_name, ENT_QUOTES, 'UTF-8')."</td>"
  ."<td>".htmlspecialchars($page->results, ENT_QUOTES, 'UTF-8')."</td>"
  ?>

  <td>
  <a class="details" href="/pagination/edit/<?=$page->id?>">Edit</a>
  <br/>
  <a class="details" href="/pagination/delete/<?=$page->id?>">Delete</a>
  <td>  
  </tr>
<?php endforeach; ?>
</table>
<br/>
<br/>
<a href="/pagination/save">Add New Pagination Record</a></li>