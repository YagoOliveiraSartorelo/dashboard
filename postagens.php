<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Postagens - Dashboard</title>
    <link rel="stylesheet" href="dash.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    
    <style>
        /* ESTILO DO MODAL (adaptado para o tema escuro neon) */
        .modal {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.9);
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }
        .modal-content {
            background: #1a1a1a;
            color: #fff;
            border-radius: 16px;
            padding: 30px;
            width: 100%;
            max-width: 580px;
            box-shadow: 0 10px 40px rgba(0, 255, 204, 0.3);
            border: 1px solid rgba(0, 255, 204, 0.3);
        }
        .modal-content h2 {
            margin: 0 0 8px 0;
            color: #00ffcc;
        }
        .modal-content p {
            color: #aaa;
            margin-bottom: 20px;
        }
        .modal-content label {
            display: block;
            margin: 15px 0 6px;
            font-weight: 600;
            color: #ddd;
        }
        .modal-content input,
        .modal-content select,
        .modal-content textarea {
            width: 100%;
            padding: 12px 14px;
            background: #222;
            border: 1px solid #00ffcc;
            border-radius: 8px;
            font-size: 16px;
            color: #fff;
            box-sizing: border-box;
        }
        .modal-content textarea {
            min-height: 120px;
            resize: vertical;
        }
        .button-group {
            margin-top: 30px;
            display: flex;
            gap: 12px;
        }
        .btn-modal {
            flex: 1;
            padding: 14px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-success { background: #00ffcc; color: #000; }
        .btn-danger   { background: #ff3366; color: white; }
        .btn-success:hover { background: #00ffaa; }
        .btn-danger:hover   { background: #ff5577; }

        /* Estilos da página (do design moderno) */
        .header-page {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .table-container {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(0, 255, 204, 0.2);
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 16px;
            text-align: left;
            border-bottom: 1px solid rgba(0, 255, 204, 0.1);
        }
        th {
            color: #00ffcc;
            font-weight: 600;
            background: rgba(0, 255, 204, 0.05);
        }
        tr:hover {
            background: rgba(0, 255, 204, 0.08);
        }
        .status {
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 600;
        }
        .status.ativo {
            background: rgba(0, 204, 136, 0.2);
            color: #00ffaa;
        }
        .status.inativo {
            background: rgba(255, 51, 102, 0.2);
            color: #ff5577;
        }
        .acoes button {
            background: none;
            border: none;
            color: #aaa;
            font-size: 18px;
            margin: 0 6px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .acoes button:hover {
            color: #00ffcc;
            transform: scale(1.2);
        }
        .btn-add {
            background: #00ffcc;
            color: #000;
            padding: 12px 28px;
            border-radius: 8px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
        }
        .btn-add:hover {
            background: #00ffaa;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav>
        <div style="margin-bottom: 40px;">
            <h2 style="color: #00ffcc; font-size: 26px;">Dashboard</h2>
        </div>
       
        <a href="index.php"><i class="fas fa-home"></i> Início</a>
        <a href="usuarios.php"><i class="fas fa-users"></i> Usuários</a>
        <a href="categorias.php"><i class="fas fa-tags"></i> Categorias</a>
        <a href="postagens.php" class="active"><i class="fas fa-file-alt"></i> Postagens</a>
        
        <!-- Perfil -->
        <div class="perfil-usuario">
            <i class="fas fa-user-circle" style="font-size: 46px; color: #00ffcc;"></i>
            <div>
                <strong>Yago Oliveira</strong><br>
                <small style="color: #00ffcc;">Administrador</small>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <div class="header-page">
            <div>
                <h1>Gestão de Postagens</h1>
                <p class="subtitle">Visualize e gerencie as postagens de produtos do sistema</p>
            </div>
            <button id="btnAdicionar" class="btn-add">
                <i class="fas fa-plus"></i> Nova Postagem
            </button>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Conteúdo</th>
                        <th>Categoria</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </main>

    <!-- ====================== MODAL ====================== -->
    <div id="modalPostagem" class="modal">
        <div class="modal-content">
            <h2 id="modalTitle">Nova Postagem</h2>
            <p>Preencha os dados abaixo</p>

            <form id="formPostagem">
                <label>ID</label>
                <input type="text" id="idField" value="Auto" readonly>

                <label for="titulo">Título <span style="color:red">*</span></label>
                <input type="text" id="titulo" required>

                <label for="conteudo">Conteúdo <span style="color:red">*</span></label>
                <textarea id="conteudo" required></textarea>

                <label for="categoria">Categoria <span style="color:red">*</span></label>
                <select id="categoria" required></select>

                <label for="status">Status</label>
                <select id="status">
                    <option value="Ativo" selected>Ativo</option>
                    <option value="Inativo">Inativo</option>
                </select>

                <div class="button-group">
                    <button type="button" id="btnFinalizar" class="btn-modal btn-success">
                        <i class="fa-solid fa-check"></i> <span id="btnText">Finalizar Cadastro</span>
                    </button>
                    <button type="button" id="btnCancelar" class="btn-modal btn-danger">
                        <i class="fa-solid fa-xmark"></i> Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let postagens = JSON.parse(localStorage.getItem('bancoPostagens')) || [
            { id: 1, titulo: "Smartphone Galaxy S25 Ultra", conteudo: "Review completo do novo flagship da Samsung com câmera de 200MP...", categoria: "Eletrônicos", status: "Ativo" },
            { id: 2, titulo: "Camiseta Básica Algodão Premium", conteudo: "Camiseta 100% algodão egípcio, disponível em várias cores...", categoria: "Roupas e Moda", status: "Ativo" },
            { id: 3, titulo: "Notebook Dell Inspiron 15", conteudo: "Processador Intel i7, 16GB RAM, SSD 512GB...", categoria: "Eletrônicos", status: "Inativo" },
            { id: 4, titulo: "Kit de Panelas Antiaderente", conteudo: "Conjunto com 5 peças, revestimento antiaderente de alta qualidade...", categoria: "Alimentos e Bebidas", status: "Ativo" }
        ];

        let editingId = null;

        function getNextId() {
            if (postagens.length === 0) return 5;
            const maxId = Math.max(...postagens.map(p => p.id));
            return maxId + 1;
        }

        function carregarCategorias() {
            const select = document.getElementById('categoria');
            select.innerHTML = '<option value="">Selecione uma categoria...</option>';
            const categorias = JSON.parse(localStorage.getItem('bancoCategorias')) || [];
            categorias.forEach(cat => {
                const option = document.createElement('option');
                option.value = cat.nome;
                option.textContent = cat.nome;
                select.appendChild(option);
            });
        }

        function renderTabela() {
            const tbody = document.querySelector('tbody');
            tbody.innerHTML = '';

            postagens.forEach(post => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${post.id.toString().padStart(2, '0')}</td>
                    <td>${post.titulo}</td>
                    <td>${post.conteudo.substring(0, 60)}${post.conteudo.length > 60 ? '...' : ''}</td>
                    <td>${post.categoria}</td>
                    <td><span class="status ${post.status.toLowerCase()}">${post.status}</span></td>
                    <td class="acoes">
                        <button class="btn-edit" data-id="${post.id}" title="Editar"><i class="fas fa-pen"></i></button>
                        <button class="btn-view" data-id="${post.id}" title="Visualizar"><i class="fas fa-eye"></i></button>
                        <button class="btn-delete" data-id="${post.id}" title="Excluir"><i class="fas fa-trash"></i></button>
                    </td>
                `;
                tbody.appendChild(tr);
            });

            adicionarEventos();
        }

        function salvarDados() {
            localStorage.setItem('bancoPostagens', JSON.stringify(postagens));
        }

        function adicionarEventos() {
            document.querySelectorAll('.btn-edit').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = parseInt(btn.getAttribute('data-id'));
                    const post = postagens.find(p => p.id === id);
                    if (!post) return;

                    editingId = id;
                    document.getElementById('modalTitle').textContent = 'Editar Postagem';
                    document.getElementById('btnText').textContent = 'Salvar Alterações';
                    document.getElementById('idField').value = id.toString().padStart(2, '0');
                    document.getElementById('titulo').value = post.titulo;
                    document.getElementById('conteudo').value = post.conteudo;
                    document.getElementById('categoria').value = post.categoria;
                    document.getElementById('status').value = post.status;

                    document.getElementById('modalPostagem').style.display = 'flex';
                });
            });

            document.querySelectorAll('.btn-view').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = parseInt(btn.getAttribute('data-id'));
                    const post = postagens.find(p => p.id === id);
                    if (post) {
                        alert(`DETALHES DA POSTAGEM\n\nID: ${post.id}\nTítulo: ${post.titulo}\nConteúdo: ${post.conteudo}\nCategoria: ${post.categoria}\nStatus: ${post.status}`);
                    }
                });
            });

            document.querySelectorAll('.btn-delete').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = parseInt(btn.getAttribute('data-id'));
                    const post = postagens.find(p => p.id === id);
                    if (!post) return;

                    if (confirm(`Tem certeza que deseja excluir "${post.titulo}"?`)) {
                        postagens = postagens.filter(p => p.id !== id);
                        salvarDados();
                        renderTabela();
                        alert('Postagem excluída com sucesso!');
                    }
                });
            });
        }

        // Modal controls
        const modal = document.getElementById('modalPostagem');
        const btnAdicionar = document.getElementById('btnAdicionar');
        const btnCancelar = document.getElementById('btnCancelar');
        const btnFinalizar = document.getElementById('btnFinalizar');

        btnAdicionar.addEventListener('click', () => {
            editingId = null;
            document.getElementById('modalTitle').textContent = 'Nova Postagem';
            document.getElementById('btnText').textContent = 'Finalizar Cadastro';
            document.getElementById('formPostagem').reset();
            document.getElementById('idField').value = 'Auto';
            carregarCategorias();
            modal.style.display = 'flex';
        });

        btnCancelar.addEventListener('click', () => {
            modal.style.display = 'none';
            editingId = null;
        });

        btnFinalizar.addEventListener('click', () => {
            const titulo = document.getElementById('titulo').value.trim();
            const conteudo = document.getElementById('conteudo').value.trim();
            const categoria = document.getElementById('categoria').value;
            const status = document.getElementById('status').value;

            if (!titulo || !conteudo || !categoria) {
                alert('Por favor, preencha todos os campos obrigatórios!');
                return;
            }

            if (editingId !== null) {
                const post = postagens.find(p => p.id === editingId);
                if (post) {
                    post.titulo = titulo;
                    post.conteudo = conteudo;
                    post.categoria = categoria;
                    post.status = status;
                }
            } else {
                const novaPostagem = {
                    id: getNextId(),
                    titulo: titulo,
                    conteudo: conteudo,
                    categoria: categoria,
                    status: status
                };
                postagens.push(novaPostagem);
            }

            salvarDados();
            renderTabela();
            alert(editingId !== null ? '✅ Postagem atualizada com sucesso!' : '✅ Postagem cadastrada com sucesso!');
            modal.style.display = 'none';
            editingId = null;
        });

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
                editingId = null;
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            carregarCategorias();
            renderTabela();
        });
    </script>
</body>
</html>
