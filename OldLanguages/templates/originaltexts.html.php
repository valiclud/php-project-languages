<p><?=$totalOriginalTexts?> originals text have been submitted to the Internet Old Text Database.</p>
<table>
<tr>
    <th>Title</th>
    <th>Original Text</th>
    <th>Translated Text</th>
    <th>Place</th>
    <th>Old Language</th>
    <th>Date</th>
    <th>Actions</th>
  </tr>
<?php foreach ($originalTexts as $originalText): ?>
  <tr>
  <?php 
  $date = date_create($originalText['insert_date']);
  echo "<td hidden>".htmlspecialchars($originalText['id'], ENT_QUOTES, 'UTF-8')."</td>"
  ."<td>".htmlspecialchars($originalText['title'], ENT_QUOTES, 'UTF-8')."</td>"
  ."<td>".htmlspecialchars($originalText['text'], ENT_QUOTES, 'UTF-8')."</td>"
  ."<td>".htmlspecialchars($originalText['translatedText'], ENT_QUOTES, 'UTF-8')."</td>"
  ."<td>".htmlspecialchars($originalText['place'], ENT_QUOTES, 'UTF-8')."</td>"
  ."<td>".htmlspecialchars($originalText['old_languages'], ENT_QUOTES, 'UTF-8')."</td>" 
  ."<td>".htmlspecialchars(date_format($date,"d-m-Y"), ENT_QUOTES, 'UTF-8')."</td>" 
  ?>
  <td><a class="details" href="index.php?route=originaltext/edit&id=<?=$originalText['id']?>">Edit</a>
  </br>
  <a class="details" href="index.php?route=originaltext/delete&id=<?=$originalText['id']?>">Delete</a>
  <td>  
</td>
</tr>
<?php endforeach; ?>
</table>