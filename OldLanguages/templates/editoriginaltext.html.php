<form action="" method="post">
  <input type="hidden" name="originaltext[id]" value="<?= $originalText->id ?? '' ?>">
  <label for="originaltext">Type your original text:</label>
  <textarea id="originaltext" name="originaltext[text]" rows="3" cols="40"><?= $originalText->text ?? '' ?></textarea>

  <label for="forlanguage"> Language : </label>
  <select id="idLanguage" name="originaltext[old_language_id]" ">
    <option value=" 1">Select Language</option>
    <?php foreach ($originalText->getAllOldLanguages() as $lang) : ?>
      <option value="<?= $lang->id ?>" <?= ($lang->id == $originalText->old_language_id) ? ' selected' : '' ?>><?= htmlspecialchars($lang->language) ?>
      </option>";
    <?php endforeach; ?>
  </select>

  <label for="forplace"> Place : </label>
  <select id="idPlace" name="originaltext[place_id]" ">
    <option value=" 1">Select Place</option>
    <?php foreach ($originalText->getAllPlaces() as $p) : ?>
      <option value="<?= $p->id ?>" <?= ($p->id == $originalText->place_id) ? ' selected' : '' ?>><?= htmlspecialchars($p->place) ?>
      </option>";
    <?php endforeach; ?>
  </select>

  <input type="hidden" name="selected_text" id="selected_text" value="" />
  <input type="submit" name="submit" value="Save">
</form>