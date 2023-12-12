<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="createUserModalLabel">Criar Novo Usuário</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="index.php" method="post">
                <input type="hidden" name="action" value="create">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="setores">Selecionar Setores:</label>
                    <select name="setores[]" multiple class="form-control">
                        <?php foreach ($setores as $setor): ?>
                            <option value="<?= $setor['id']; ?>"><?= $setor['nome']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Criar Usuário</button>
            </form>
        </div>
    </div>
</div>
