<table>
    <tr>
        <th>Statistics name</th>
        <th>Statistics value</th>
    </tr>
    <tr>
        <td>Number of authors translated texts</td>
        <?php
        echo "<td>" . htmlspecialchars($noOfAuthorsTransText, ENT_QUOTES, 'UTF-8') . "</td>"
        ?>
    </tr>
    <tr>
        <td>Number of translated texts</td>
        <?php
        echo "<td>" . htmlspecialchars($noOfTransText, ENT_QUOTES, 'UTF-8') . "</td>"
        ?>
    </tr>
    <tr>
        <td>Number of original languages</td>
        <?php
        echo "<td>" . htmlspecialchars($noOfOrigLanguage, ENT_QUOTES, 'UTF-8') . "</td>"
        ?>
    </tr>
</table>