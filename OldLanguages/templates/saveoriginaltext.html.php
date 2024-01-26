<form action="" method="post">
  <label for="originaltext">Type author of original text:</label>
  <input id="originaltext" name="originaltext[author]"><?= $originalText->author ?? '' ?></input>
  <label for="originaltext">Type title of original text:</label>
  <input id="originaltext" name="originaltext[title]"><?= $originalText->title ?? '' ?></input>
  <label for="originaltext">Century:</label>
  <input id="originaltext" name="originaltext[title]"><?= $originalText->title ?? '' ?></input>
  <label for="originaltext">Type your original text:</label>
  <textarea id="originaltext" name="originaltext[text]" rows="3" cols="40"><?= $originalText->text ?? '' ?></textarea>
  <label for="originaltext">Century:</label>
  <input id="originaltext" name="originaltext[century]"><?= $originalText->century ?? '' ?></input>

  <label for="forlanguage"> Language : </label>
  <select id="idLanguage" name="originaltext[old_language_id]" ">
    <option value=" 0">Select Language</option>
    <?php foreach ($originalText->getAllOldLanguages() as $lang) : ?>
      <option value="<?= $lang->id ?>"><?= htmlspecialchars($lang->language) ?>
      </option>";
    <?php endforeach; ?>
  </select>

  <label for="forplace"> Place : </label>
  <select id="idPlace" name="originaltext[place_id]" ">
    <option value=" 0">Select Place</option>
    <?php foreach ($originalText->getAllPlaces() as $p) : ?>
      <option value="<?= $p->id ?>"><?= htmlspecialchars($p->place) ?>
      </option>";
    <?php endforeach; ?>
  </select>

  <input type="hidden" name="selected_text" id="selected_text" value="" />
  <input type="submit" name="submit" value="Save">
</form>