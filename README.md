<h1 align='center'>Api Cardapio Digital</h1>
<h2>
    Essa api foi desenvolvida com o intuito de melhorar minhas habilidades com o desevolvimento backend php/laravel, fique a vontade para testa-lá em <a href="https://coderunning.tech/api-cardapio-digital">api cardapio digital</a>.
</h2>
<ul>     
    <li><a href="#auth">Autenticação</a></li>
    <li><a href="#user">Informações de Usuário</a></li>
    <li><a href="#management">Gerenciamento de Usuários</a></li>    
    <li><a href="#category">Categorias</a></li>    
    <li><a href="#product">Produtos</a></li>        
    <li><a href="#sale">Vendas</a></li>    
    <li><a href="#payment">Pagamento</a></li>        
</ul>

<h2 id="auth">Autenticação</h2>
<ul>
    <li><a href="#auth-login">Login</a></li>
    <li><a href="#auth-logout">Logout</a></li>
    <li><a href="#auth-refresh">Refresh</a></li>
    <li><a href="#auth-register">Register</a></li>            
</ul>

<h3 id="auth-login">Login</h3>
<p>
    A rota de verbo POST <b>api/auth/login</b> serve para autenticar um usuário no sistema, para realizar essa autenticação é necessario enviar um email e uma senha, caso as credencias sejam validas irá te retornar um token que deve ser enviado no cabeçalho das proximas requisições.
    Login ex:

    Javascript Fetch
    fetch('api/auth/login', [
        method: post,        
        body: JSON.stringify({
            email: you@email.com,
            password: youpassword123
        })
    ])
</p>

<h3 id="auth-logout">Logout</h3>
<p>
    A rota de verbo POST <b>api/auth/logout</b> é utilizada para revogar a autenticação de um usuário.
</p>

<h3 id="auth-refresh">Refresh</h3>
<p>
    A rota de verbo POST <b>api/auth/refresh</b> é utilizada para renovar o token. Para realizar essa renovação basta enviar o token antigo no cabeçalho da requisição, se o token for valido irá retorna um novo token.
    Ex: 

    Javascript Fetch
    fetch('api/auth/login', [
        method: post,        
        headers: {
            Authorization: 'Bearer ' + token 
        }
    ])
</p>

<h3 id="auth-register">Register</h3>
<p>
    A rota de verbo POST <b>api/auth/register</b> serve para registrar novos usuários no sistema. Para realizar esse registro, deve ser enviado um email, senha e a confirmação dessa senha. Se os dados enviados forem válidos, irá te retornar o status code 201 confirmando a criação desse usuário. Ex: 

    Javascript Fetch
    fetch('api/auth/register', [
        method: post,        
        body: JSON.stringify({
            email: you@email.com,
            password: password123,
            password_confirmation: password123    
        })
    ])

</p>

<h2 id="category">Categorias</h2>
<h3>Rotas</h3>
<ul>    
    <li>GET: <b>api/category</b></li>
    <li>GET: <b>api/category/id</b></li>
    <li>POST: <b>api/category/create</b></li>
    <li>PUT: <b>api/category/update/id</b></li>
    <li>DELETE: <b>api/category/delete/id</b></li>
</ul>
<p>
Ao acessar a rota de verbo GET <b>api/category</b> irá te retornar um json com todas as categorias existens no sistema, caso deseje trazer as informações de uma categoria específica basta incluir o id da mesma.
Para criar uma nova categoria basta acessar a rota de verbo POST <b>api/category/create</b>, é necessario que o usuário esteja autenticado como administrador. Essa rota espera os seguintes dados: name.
Ex.: 

    Javascript Fetch
    fetch('api/category/create', [
        method: post,        
        headers: [
            "Authorization": "Bearer" + token
        ],
        body: JSON.stringify({
            name: string category name
        })
    ])

Para atualizar os dados da categoria basta acessar a rota de verbo PUT <b>api/category/update/id</b> informando o id da categoria que desenha atualizar, assim como a criação de uma nova categoria a atualização espera um usuário autenticado como administrador. Essa rota espera que seja informada pelo menos um dos dados citados na criação.

Para deletar uma categoria basta acessar a rota de verbo DELETE <b>api/category/delete/id</b> informando o id da categoria que deseja deletar. Assim como as demais rotas é necessario que o usuário esteja autenticado como administrador.
</p>

<h2 id="product">Produtos</h2>
<h3>Rotas</h3>
<ul>    
    <li>GET: <b>api/produto</b></li>
    <li>GET: <b>api/produto/id</b></li>
    <li>POST: <b>api/produto/create</b></li>
    <li>PUT: <b>api/produto/update/id</b></li>
    <li>DELETE: <b>api/produto/delete/id</b></li>
</ul>
<p>
Ao acessar a rota de verbo GET <b>api/product</b> irá te retornar um json com todos os produtos existens no sistema, caso deseje trazer as informações de um produto basta incluir o id.
Para criar uma novo produto basta acessar a rota de verbo POST <b>api/product/create</b>, é necessario que o usuário esteja autenticado como administrador. Essa rota espera os seguintes dados: category, name, price, description, thumb.

Ex.: 

    Javascript Fetch
    fetch('api/product/create', [
        method: post,        
        headers: [
            "Authorization": "Bearer" + token
        ],
        body: JSON.stringify({
            category: int categoryId
            name => string product name,
            price => float product price,
            description => string product description,
            thumb => image product thumb
        })
    ])

Para atualizar os dados de um produto basta acessar a rota de verbo PUT <b>api/product/update/id</b> informando o id do produto que deseja atualizar.

Para deletar um produto basta acessar a rota de verbo DELETE <b>api/product/delete/id</b> informando o id do produto que deseja atualizar
</p>