<?php ?>

<?php if ($this->data['criticalError']): ?>
<!-- CRITICAL ERROR -->
<div style="width=100%; margin: 0 auto" class="alert alert-danger">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#dc3545" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
    </svg>
    <span>Błąd krytyczny</span>
</div>
<?php else: ?>

<!-- ENTIRE DATAGRID CONTAINER -->
<div style="width: 100%; margin: 0 auto">
    <table class="table table-bordered">
        <!-- HEADERS -->
        <thead>
            <tr>
                <?php foreach ($this->data['headers'] as $key => $value): ?><th style="text-align: <?php echo $value['align']; ?>">
                    <a href="<?php echo $value['url']; ?>">
                        <?php echo $value['content']; ?>
                        <?php if ($value['sort'] === 'asc'): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"/>
                            </svg>
                        <?php endif; ?>
                        <?php if ($value['sort'] === 'desc'): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z"/>
                            </svg>
                        <?php endif; ?>
                    </a>
                </th><?php endforeach; ?>
            </tr>
        </thead>
        <!-- CELLS DATA PART -->
        <tbody>
            <?php for($iRow = 0; $iRow <= $this->data['rowsCount']; $iRow++): ?>
            <tr>
                <?php if ($this->data['shouldRenderRow'][$iRow]): ?>
                    <td colspan="<?php print $this->data['columnsCount']; ?>" class="alert alert-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#8b0000" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                        </svg> Błąd wiersza - w tym wierszu znajdują się błędne dane
                    </td>
                <?php else: ?>
                    <?php foreach ($this->data['cells'][$iRow] as $key => $value): ?>
                    <td style="text-align: <?php echo $value['align']; ?>">
                        <?php if ($value['error']): ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#dc3545" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                        </svg>
                        <?php else: echo $value['content']; ?>
                        <?php endif; ?>
                    </td>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tr>
            <?php endfor; ?>
        </tbody>
    </table>

    <!-- PAGINATION PART -->
    <?php if ($this->data['pagination']['shouldRender']): ?>
        <div class="text-center">
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <!-- PREVIOUS BUTTON -->
                    <?php if ($this->data['pagination']['previousButton']['isActive']): ?>
                    <li class="page-item">
                    <?php else: ?>
                    <li class="page-item disabled">
                        <?php endif; ?>
                        <a class="page-link" href="<?php echo $this->data['pagination']['previousButton']['url']; ?>"><u>Previous</u></a>
                    </li>
                    <!-- PAGES -->
                    <?php for($iPage = 1; $iPage <= $this->data['pagesCount']; $iPage++): ?>
                    <?php if ($this->data['pagination'][$iPage]['isActive']): ?>
                    <li class="page-item">
                    <?php else: ?>
                    <li class="page-item active">
                    <?php endif; ?>
                    <a class="page-link" href="<?php echo $this->data['pagination'][$iPage]['url']; ?>">
                        <u><?php echo $this->data['pagination'][$iPage]['text']; ?></u>
                    </a>
                    </li>
                    <?php endfor; ?>
                    <!-- NEXT BUTTON -->
                    <?php if ($this->data['pagination']['nextButton']['isActive']): ?>
                    <li class="page-item">
                    <?php else: ?>
                    <li class="page-item disabled">
                    <?php endif; ?>
                        <a class="page-link" href="<?php echo $this->data['pagination']['nextButton']['url']; ?>"><u>Next</u></a>
                    </li>
                </ul>
            </nav>
        </div>
    <?php endif; ?>
</div>
<?php endif; ?>