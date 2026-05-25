const API_BASE = '../api/';

const mockData = {
  dashboard: {
    noticias: 14,
    vereadores: 11,
    diarios: 8,
    legislacoes: 27,
    concursos: 3,
    esicPendentes: 5,
    ouvidoriaPendente: 4,
    usuarios: 6
  },
  noticias: [
    { id: 1, titulo: 'Sessão ordinária desta semana', status: 'Publicada', data: '2026-05-23' },
    { id: 2, titulo: 'Audiência pública sobre saúde', status: 'Rascunho', data: '2026-05-20' }
  ],
  vereadores: [
    { id: 1, nome: 'Ana Souza', partido: 'ABC', status: 'Ativo' },
    { id: 2, nome: 'Carlos Lima', partido: 'DEF', status: 'Ativo' }
  ],
  diario: [
    { id: 1, edicao: '125', data: '2026-05-21', status: 'Publicado' },
    { id: 2, edicao: '124', data: '2026-05-14', status: 'Publicado' }
  ],
  legislacao: [
    { id: 1, numero: 'PL 012/2026', tipo: 'Projeto de Lei', status: 'Em tramitação' },
    { id: 2, numero: 'LC 003/2026', tipo: 'Lei Complementar', status: 'Aprovada' }
  ],
  concursos: [{ titulo: 'Concurso Administrativo 2026', status: 'Inscrições abertas' }],
  esic: [{ protocolo: 'ESIC-2026-0004', assunto: 'Acesso a contratos', status: 'Em análise' }],
  ouvidoria: [{ protocolo: 'OUV-2026-0012', assunto: 'Solicitação de informação', status: 'Pendente' }],
  configuracoes: [{ chave: 'tema', valor: 'escuro' }, { chave: 'nome_painel', valor: 'Painel Câmara' }],
  usuarios: [{ nome: 'Administrador', email: 'admin@camara.gov.br', perfil: 'Admin' }]
};

const titles = {
  dashboard: 'Dashboard',
  noticias: 'Notícias',
  vereadores: 'Vereadores',
  diario: 'Diário Oficial',
  legislacao: 'Legislação',
  concursos: 'Concursos',
  esic: 'e-SIC',
  ouvidoria: 'Ouvidoria',
  configuracoes: 'Configurações',
  usuarios: 'Usuários'
};

const container = document.getElementById('view-container');
const titleEl = document.getElementById('view-title');
const menu = document.getElementById('menu');

function renderTable(headers, rows) {
  return `
    <div class="table-wrap">
      <table>
        <thead><tr>${headers.map((h) => `<th>${h}</th>`).join('')}</tr></thead>
        <tbody>
          ${rows.map((row) => `<tr>${row.map((cell) => `<td>${cell}</td>`).join('')}</tr>`).join('')}
        </tbody>
      </table>
    </div>`;
}

function renderView(view) {
  titleEl.textContent = titles[view] || 'Painel';

  if (view === 'dashboard') {
    const d = mockData.dashboard;
    container.innerHTML = `
      <div class="grid">
        <article class="card"><h3>Notícias</h3><div class="kpi">${d.noticias}</div></article>
        <article class="card"><h3>Vereadores</h3><div class="kpi">${d.vereadores}</div></article>
        <article class="card"><h3>Diários</h3><div class="kpi">${d.diarios}</div></article>
        <article class="card"><h3>Legislação</h3><div class="kpi">${d.legislacoes}</div></article>
        <article class="card"><h3>Concursos</h3><div class="kpi">${d.concursos}</div></article>
        <article class="card"><h3>e-SIC pendentes</h3><div class="kpi">${d.esicPendentes}</div></article>
        <article class="card"><h3>Ouvidoria pendente</h3><div class="kpi">${d.ouvidoriaPendente}</div></article>
        <article class="card"><h3>Usuários</h3><div class="kpi">${d.usuarios}</div></article>
      </div>
      <div class="panel-note">SPA único em funcionamento. Integrações futuras devem usar <strong>API_BASE</strong>: ${API_BASE}</div>
    `;
    return;
  }

  if (view === 'noticias') {
    container.innerHTML = renderTable(['ID', 'Título', 'Status', 'Data'], mockData.noticias.map((n) => [n.id, n.titulo, `<span class="badge ${n.status === 'Publicada' ? 'ok' : 'warn'}">${n.status}</span>`, n.data]));
    return;
  }
  if (view === 'vereadores') {
    container.innerHTML = renderTable(['ID', 'Nome', 'Partido', 'Status'], mockData.vereadores.map((v) => [v.id, v.nome, v.partido, `<span class="badge ok">${v.status}</span>`]));
    return;
  }
  if (view === 'diario') {
    container.innerHTML = renderTable(['ID', 'Edição', 'Data', 'Status'], mockData.diario.map((d) => [d.id, d.edicao, d.data, `<span class="badge info">${d.status}</span>`]));
    return;
  }
  if (view === 'legislacao') {
    container.innerHTML = renderTable(['ID', 'Número', 'Tipo', 'Status'], mockData.legislacao.map((l) => [l.id, l.numero, l.tipo, `<span class="badge warn">${l.status}</span>`]));
    return;
  }

  const generic = mockData[view] || [];
  container.innerHTML = generic.length
    ? renderTable(Object.keys(generic[0]).map((k) => k.toUpperCase()), generic.map((obj) => Object.values(obj)))
    : '<div class="panel-note">Sem dados mockados para esta seção.</div>';
}

menu.addEventListener('click', (event) => {
  const button = event.target.closest('.menu-item');
  if (!button) return;

  menu.querySelectorAll('.menu-item').forEach((item) => item.classList.remove('active'));
  button.classList.add('active');

  renderView(button.dataset.view);
});

// Funções vazias para integração futura
function loadNoticias() {}
function saveNoticia() {}
function deleteNoticia() {}
function loadVereadores() {}
function saveVereador() {}
function deleteVereador() {}
function loadDiario() {}
function saveDiario() {}
function deleteDiario() {}
function loadLegislacao() {}
function saveLegislacao() {}
function deleteLegislacao() {}

renderView('dashboard');
