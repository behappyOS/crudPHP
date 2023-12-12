<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="deleteUserModalLabel">Excluir Usuário</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>Você tem certeza que deseja excluir este usuário?</p>
            <form action="index.php" method="post">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="user_id" value="<?= $usuario['id']; ?>">
                <button type="submit" class="btn btn-danger">Sim, Excluir</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </form>
        </div>
    </div>
</div>
