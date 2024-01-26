<p><?=$totalTranslatedTexts?> translated texts have been submitted to the Internet Old Text Database.</p>
<table>
<tr>
    <th>Author</th>
    <th>Title</th>
    <th>Translated Text</th>
    <th>Original Text Title</th>
    <th>Revision</th>
    <th>Insert Date</th>
    <th>Actions</th>
  </tr>
<?php foreach ($translatedTexts as $translatedText): ?>
  <tr>
  <?php 
  $date = date_create($translatedText->insert_date);
  echo "<td hidden>".htmlspecialchars($translatedText->id, ENT_QUOTES, 'UTF-8')."</td>"
  ."<td>".htmlspecialchars($translatedText->author, ENT_QUOTES, 'UTF-8')."</td>"
  ."<td>".htmlspecialchars($translatedText->title, ENT_QUOTES, 'UTF-8')."</td>"
  ."<td>".htmlspecialchars($translatedText->text, ENT_QUOTES, 'UTF-8')."</td>"
  ."<td>".htmlspecialchars($translatedText->getOriginalText()->title, ENT_QUOTES, 'UTF-8')."</td>"
  ."<td>".htmlspecialchars($translatedText->revision, ENT_QUOTES, 'UTF-8')."</td>"
  ."<td>".htmlspecialchars($translatedText->insert_date, ENT_QUOTES, 'UTF-8')."</td>" 
  ?>

  <td>
  <a class="details" href="/translatedtext/edit/<?=$translatedText->id?>">Edit</a>
  <br/>
  <a class="details" href="/translatedtext/delete/<?=$translatedText->id?>">Delete</a>
  <td>  
  </tr>
<?php endforeach; ?>
</table>