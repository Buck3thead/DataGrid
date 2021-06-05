<?php

?>
<form action="<?php echo $data['link']['url']; ?>">
    <button type="submit"<?php
    if ($data['link']['class'] <> '') {
        echo ' class="' . $data['link']['class'] . '">';
    }
    echo $data['link']['url'];
    ?></button>
</form>