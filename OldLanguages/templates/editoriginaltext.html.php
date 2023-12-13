<form action="" method="post">
  <input type="hidden" name="origtextid" value="<?= $originalText['id'] ?? '' ?>">
  <label for="originaltext">Type your original text:</label>
  <textarea id="originaltext" name="originalText" rows="3" cols="40"><?= $originalText['text'] ?? '' ?></textarea>

  <input type="hidden" name="translatedtextid" value="<?= $translatedText['id'] ?? '' ?>">
  <label for="translatedtext">Type your translated text:</label>
  <textarea id="translatedtext" name="translatedText" rows="3" cols="40"><?= $translatedText['text'] ?? '' ?></textarea>

  <label for="forlanguage"> Language : </label>
  <select id="idLanguage" name="language" ">
    <option value=" 1">Select Language</option>
    <?php foreach ($originalText['languages'] as $lang) : ?>
      <option value="<?= $lang["id"] ?>" <?= ($lang["id"] == $originalText["old_language_id"]) ? ' selected' : '' ?>><?= htmlspecialchars($lang["old_language"]) ?>
      </option>";
    <?php endforeach; ?>
  </select>

  <label for="forplace"> Place : </label>
  <select id="idPlace" name="place" ">
    <option value=" 1">Select Place</option>
    <?php foreach ($originalText['places'] as $p) : ?>
      <option value="<?= $p["id"] ?>" <?= ($p["id"] == $originalText["place_id"]) ? ' selected' : '' ?>><?= htmlspecialchars($p["country"]) ?>
      </option>";
    <?php endforeach; ?>
  </select>

  <input type="hidden" name="selected_text" id="selected_text" value="" />
  <input type="submit" name="submit" value="Save">
</form>