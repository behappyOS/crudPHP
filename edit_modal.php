<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editUserModalLabel">Editar Usuário</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="index.php" method="post">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="user_id" value="<?= $usuario['id']; ?>">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" class="form-control" value="<?= $usuario['nome']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" class="form-control" value="<?= $usuario['email']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="setores">Selecionar Setores:</label>
                    <select name="setores[]" multiple class="form-control">
                        <?php foreach ($setores as $setor): ?>
                            <option value="<?= $setor['id']; ?>" <?= (in_array($setor['id'], getUserSetores($usuario['id']))) ? 'selected' : ''; ?>>
                                <?= $setor['nome']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-warning">Salvar Alterações</button>
            </form>
        </div>
    </div>
</div>
