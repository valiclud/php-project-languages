<form action="" method="post">
    <input type="hidden" name="translatedtext[id]" value="<?= $translatedText->id ?? '' ?>">
    <label for="translatedtext">Type author of translated text:</label>
    <input id="translatedtext" name="translatedtext[author]" value="<?= $translatedText->author ?? '' ?>"></input>
    <label for="translatedtext">Type title of translated text:</label>
    <input id="translatedtext" name="translatedtext[title]" value="<?= $translatedText->title ?? '' ?>"></input>
    <label for="translatedtext">Type your translated text:</label>
    <textarea id="translatedtext" name="translatedtext[text]" rows="3" cols="40"><?= $translatedText->text ?? '' ?></textarea>
    <label for="translatedtext">Language:</label>
    <input id="translatedtext" name="translatedtext[language]" value="<?= $translatedText->language ?? '' ?>"></input>

    <label for="forlanguage"> Original Text Title: </label>
    <select id="idLanguage" name="translatedtext[original_text_id]" ">
    <option value="1">Select Original Text to Translate</option>
        <?php foreach ($translatedText->getAllOriginalTexts() as $txt) : ?>
            <option value="<?= $txt->id ?>" <?= ($txt->id == $translatedText->original_text_id) ? ' selected' : '' ?>><?= htmlspecialchars($txt->title) ?>
            </option>";
        <?php endforeach; ?>
    </select>

    <input type="submit" name="submit" value="Save">
</form>