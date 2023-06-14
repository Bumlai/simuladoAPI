const URL = 'http://localhost:8080/alocacao.php';
const URL1 = 'http://localhost:8080/produtos.php';
const alocacoes = document.querySelectorAll('#alocacao');

function carregarAlocacao() {
    fetch(URL)
        .then(response => response.json())
        .then(alocacao => {
            fetch(URL1)
                .then(response => response.json())
                .then(produtos => {
                    alocacoes.forEach(alocacaoElement => {
                        alocacaoElement.innerHTML = '';

                        const produtosPorGalpao = {};

                        alocacao.forEach(alocacaoItem => {
                            const galpaoId = alocacaoItem.Galpao;
                            if (!produtosPorGalpao[galpaoId]) {
                                produtosPorGalpao[galpaoId] = [];
                            }
                            const produto = produtos.find(p => p.id === alocacaoItem.produto);
                            if (produto) {
                                produtosPorGalpao[galpaoId].push({
                                    descricao: produto.Descricao,
                                    preco: produto.preco,
                                    nomeEmpresa: alocacaoItem.empresa,
                                    quantidade: alocacaoItem.quantidade
                                });
                            }
                        });

                        alocacao.forEach(galpao => {
                            const div = document.createElement('div');
                            const produtosGalpao = produtosPorGalpao[galpao.Galpao];
                            const status = galpao.quantidade === 0 ? 'Desocupado' : 'Ocupado';
                            div.innerHTML = `
                                <div class="card ${status}" style="width: 200px; height: 100px;">
                                    <div class="card-body">
                                        <h5 class="card-title">${galpao.Galpao}</h5>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop${galpao.Galpao}">ver mais</button>
                                    </div>
                                </div>

                                <div class="modal fade" id="staticBackdrop${galpao.Galpao}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Descrição</th>
                                                        <th>Preço</th>
                                                        <th>Nome da empresa</th>
                                                        <th>Quantidade</th>
                                                        <th>Ação</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tabela_alocacao${galpao.Galpao}"></tbody>
                                            </table>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;

                            const tabelaAlocacao = div.querySelector(`#tabela_alocacao${galpao.Galpao}`);

                            if (produtosGalpao) {
                                produtosGalpao.forEach(produto => {
                                    const tr = document.createElement('tr');
                                    tr.innerHTML = `
                                        <td>${produto.descricao}</td>
                                        <td>${produto.preco}</td>
                                        <td>${produto.nomeEmpresa}</td>
                                        <td>${produto.quantidade}</td>
                                        <th><button data-id="${produto.id}" onclick="comprar(${produto.id})">Comprar</button></th>
                                    `;
                                    tabelaAlocacao.appendChild(tr);
                                });
                            } else {
                                div.innerHTML = `
                                    <div class="card ${status}" style="width: 200px; height: 100px;">
                                        <div class="card-body">
                                            <h5 class="card-title">${galpao.Galpao}</h5>
                                            <p>Nenhum produto encontrado para este galpão.</p>
                                        </div>
                                    </div>
                                `;
                            }

                            alocacaoElement.appendChild(div);
                        });
                    });
                });
        })
        .catch(error => {
            console.error('Ocorreu um erro:', error);
        });
}

carregarAlocacao();
