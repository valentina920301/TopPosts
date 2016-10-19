<?php if (isset($this->sLongestPostAuthor) && $this->sLongestPostAuthor != '') : ?>
    <?= $this->load('longestPost', array('sLongestPostAuthor' => $this->sLongestPostAuthor));?>
<?php endif; ?>
<p class="responseMessage <?= $this->bSuccess ? 'success' : 'error'; ?>" id="message<?= $this->iId?>" data-id="<?= $this->iId; ?>">
    <i onclick="removeMessage(<?= $this->iId; ?>)">x</i>
    <?php if ($this->bSuccess) : ?>
    <span>Your post was deleted successfully!</span>
    <?php else : ?>
    <span>We are sorry! Unfortunately, your try to delete post ended unsuccessfully! Please, try again!</span>
    <?php endif; ?>
</p>