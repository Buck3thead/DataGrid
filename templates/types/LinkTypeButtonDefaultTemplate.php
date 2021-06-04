<?php

?>
<form action="<?php echo $this->data['link']['url']; ?>">
    <button type="submit"<?php
    if ($this->data['link']['class'] <> '') {
        echo ' class="' . $this->data['link']['class'] . '">';
    }
    echo $this->data['link']['url'];
    ?></button>
</form>