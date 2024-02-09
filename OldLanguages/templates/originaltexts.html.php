<p><?=$totalOriginalTexts?> original texts have been submitted to the Internet Old Text Database.</p>
<table>
<tr>
    <th>Title</th>
    <th>Original Text</th>
    <th>Orig. Text Photo</th>
    <th>Place</th>
    <th>Old Language</th>
    <th>Date</th>
    <th>Actions</th>
  </tr>
<?php foreach ($originalTexts as $originalText): ?>
  <tr>
  <?php 
  $date = date_create($originalText->insert_date);
  echo "<td hidden>".htmlspecialchars($originalText->id, ENT_QUOTES, 'UTF-8')."</td>"
  ."<td>".htmlspecialchars($originalText->title, ENT_QUOTES, 'UTF-8')."</td>"
  ."<td>".htmlspecialchars($originalText->text, ENT_QUOTES, 'UTF-8')."</td>"
  ."<td>"
  .'<img class="autoResizeImage" src="data:image/jpeg;base64,'.base64_encode($originalText->text_img) .'" onclick="enlargeImg()" id="img1"/>'
  ."</td>"
  ."<td>".htmlspecialchars($originalText->getPlace()->place, ENT_QUOTES, 'UTF-8')."</td>"
  ."<td>".htmlspecialchars($originalText->getOldLanguage()->language, ENT_QUOTES, 'UTF-8')."</td>" 
  ."<td>".htmlspecialchars(date_format($date,"d-m-Y"), ENT_QUOTES, 'UTF-8')."</td>"
  ?>
  <td>
  <a class="details" href="/originaltext/edit/<?=$originalText->id?>">Edit</a>
  <br/>
  <a class="details" href="/originaltext/delete/<?=$originalText->id?>">Delete</a>
  <td>  
  </tr>
<?php endforeach; ?>
</table>
Select page:

<?php
for ($i = 1; $i <= $numPages; $i++):
?>
  <a href="/originaltext/list/<?=$i?>"><?=$i?></a>
<?php endfor; ?>

</div>


</div>