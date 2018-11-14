import HomeCanal from './pages/HomeCanal.vue';
import Sobre from './pages/Sobre.vue';
import Listar from './pages/Listar.vue';
import Exibir from './pages/Exibir.vue';
import ConteudoForm from './forms/ConteudoForm.vue';
import AplicativoForm from './forms/AplicativoForm.vue';
import LoginForm from './forms/LoginForm.vue';
import RecoverPassForm from './forms/RecoverPassForm.vue';
import RegisterForm from './forms/RegisterForm.vue'; 

const routes =[
    {
      path: '/',
      name: 'Home',
      component: () => import(/* webpackChunkName: "home" */ './pages/Home.vue'),
      meta: {
        requiresAuth: false
      }
    },
    {
      path: '/admin',
      name: 'Admin',
      component: () => import(/* webpackChunkName: "admin" */ './pages/Admin.vue'),
      meta: {
        requiresAuth: true,
        //is_admin : true
      }
    },    
    {
      path: '/usuario',
      name: 'User',
      component: () => import(/* webpackChunkName: "user" */ './pages/User.vue'),
      meta: {
        requiresAuth: false
      },
      children: [
        {
          path: 'login',
          name: 'Login',
          component: LoginForm
        },
        {
          path: 'recuperar-senha',
          name: 'Recover',
          component: RecoverPassForm
        },
        {
          path: 'registro',
          name: 'Register',
          component: RegisterForm
        }    
      ]
    },
    {
      path: '/:slug',
      name: 'Canal',
      component: () => import(/* webpackChunkName: "canal" */ './pages/Canal.vue'),
      meta: {
        requiresAuth: false
      },
      children: [
        {
          path: 'inicio',
          name: 'Inicio',
          component: HomeCanal
        },
        {
          path: 'sobre',
          name: 'Sobre',
          component: Sobre
        },
        {
          path: 'listar',
          name: 'Listar',
          component: Listar
        },
        {
          path: 'exibir/:id',
          name: 'Exibir',
          component: Exibir
        },
        {
          path: 'editar-conteudo/:id',
          name: 'EditarConteudo',
          component: ConteudoForm
        },
        {
          path: 'adicionar-conteudo',
          name: 'AdicionarConteudo',
          component: ConteudoForm
        },
        {
          path: 'editar-aplicativo/:id',
          name: 'EditarAplicativo',
          component: AplicativoForm
        },
        {
          path: 'adicionar-aplicativo',
          name: 'AdicionarAplicativo',
          component: AplicativoForm
        }


      ]
    }
];


export default routes;
