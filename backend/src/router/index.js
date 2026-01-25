import {createRouter, createWebHistory} from "vue-router";
import Dashboard from "../views/Dashboard.vue";
import Login from "../views/Login.vue";
import RequestPassword from "../views/RequestPassword.vue";
import ResetPassword from "../views/ResetPassword.vue";
import AppLayout from '../components/AppLayout.vue'
import store from "../store";
import NotFound from "../views/NotFound.vue";
import HomeHeroBanners from "../views/HomeHeroBanners/HomeHeroBanners.vue";
import Categories from "../views/Categories/Categories.vue";
import CategoryView from "../views/Categories/CategoryView.vue";
import Products from "../views/Products/Products.vue";
import ProductView from "../views/Products/ProductView.vue";
import ShiftsTable from "../views/Shifts/ShiftsTable.vue";
import Reviews from "../views/Reviews/Reviews.vue";
import ReviewView from "../views/Reviews/ReviewView.vue";
import Articles from "../views/Articles/Articles.vue";
import ArticleView from "../views/Articles/ArticleView.vue";
import Authors from "../views/Authors/Authors.vue";
import AuthorView from "../views/Authors/AuthorView.vue";
import Tags from "../views/Tags/Tags.vue";
import Faqs from "../views/Faqs/Faqs.vue";
import FaqView from "../views/Faqs/FaqView.vue";
import Clients from "../views/Clients/Clients.vue";
import Users from "../views/Users/Users.vue";
import Customers from "../views/Customers/Customers.vue";
import CustomerView from "../views/Customers/CustomerView.vue";
import Orders from "../views/Orders/Orders.vue";
import OrderView from "../views/Orders/OrderView.vue";
import Report from "../views/Reports/Report.vue";
import OrdersReport from "../views/Reports/OrdersReport.vue";
import CustomersReport from "../views/Reports/CustomersReport.vue";

const routes = [

  {
    path: '/',
    redirect: '/app'
  },
  {
    path: '/app',
    name: 'app',
    redirect: '/app/dashboard',
    component: AppLayout,
    meta: {
      requiresAuth: true
    },
    children: [
      {
        path: 'dashboard',
        name: 'app.dashboard',
        component: Dashboard
      },
      {
        path: 'homeherobanners',
        name: 'app.homeherobanners',
        component: HomeHeroBanners
      },
      {
        path: 'categories',
        name: 'app.categories',
        component: Categories
      },
      {
        path: 'categories/create',
        name: 'app.categories.create',
        component: CategoryView
      },
      {
        path: 'categories/:id',
        name: 'app.categories.edit',
        component: CategoryView,
        props: {
          id: (value) => /^\d+$/.test(value)
        }
      },
      {
        path: 'products',
        name: 'app.products',
        component: Products
      },
      {
        path: 'products/create',
        name: 'app.products.create',
        component: ProductView
      },
      {
        path: 'products/:id',
        name: 'app.products.edit',
        component: ProductView,
        props: {
          id: (value) => /^\d+$/.test(value)
        }
      },
      {
        path: 'pharmacy-shifts',
        name: 'app.pharmacy-shifts',
        component: ShiftsTable,
      },
      {
        path: 'reviews',
        name: 'app.reviews',
        component: Reviews
      },
      {
        path: 'reviews/create',
        name: 'app.reviews.create',
        component: ReviewView
      },
      {
        path: 'reviews/:id',
        name: 'app.reviews.edit',
        component: ReviewView,
        props: {
          id: (value) => /^\d+$/.test(value)
        }
      },
      {
        path: 'articles',
        name: 'app.articles',
        component: Articles
      },
      {
        path: 'articles/create',
        name: 'app.articles.create',
        component: ArticleView
      },
      {
        path: 'articles/:id',
        name: 'app.articles.edit',
        component: ArticleView,
        props: {
          id: (value) => /^\d+$/.test(value)
        }
      },
      {
        path: 'authors',
        name: 'app.authors',
        component: Authors
      },
      {
        path: 'authors/create',
        name: 'app.authors.create',
        component: AuthorView
      },
      {
        path: 'authors/:id',
        name: 'app.authors.edit',
        component: AuthorView,
        props: {
          id: (value) => /^\d+$/.test(value)
        }
      },
      {
        path: 'tags',
        name: 'app.tags',
        component: Tags
      },
      {
        path: 'faqs',
        name: 'app.faqs',
        component: Faqs
      },
      {
        path: 'faqs/create',
        name: 'app.faqs.create',
        component: FaqView
      },
      {
        path: 'faqs/:id',
        name: 'app.faqs.edit',
        component: FaqView,
        props: {
          id: (value) => /^\d+$/.test(value)
        }
      },
      {
        path: 'clients',
        name: 'app.clients',
        component: Clients
      },
      {
        path: 'users',
        name: 'app.users',
        component: Users
      },
      {
        path: 'customers',
        name: 'app.customers',
        component: Customers
      },
      {
        path: 'customers/:id',
        name: 'app.customers.view',
        component: CustomerView
      },
      {
        path: 'orders',
        name: 'app.orders',
        component: Orders
      },
      {
        path: 'orders/:id',
        name: 'app.orders.view',
        component: OrderView
      },
      {
        path: '/report',
        name: 'reports',
        component: Report,
        meta: {
          requiresAuth: true
        },
        children: [
          {
            path: 'orders/:date?',
            name: 'reports.orders',
            component: OrdersReport
          },
          {
            path: 'customers/:date?',
            name: 'reports.customers',
            component: CustomersReport
          }
        ]
      },
    ]
  },
  {
    path: '/login',
    name: 'login',
    component: Login,
    meta: {
      requiresGuest: true
    }
  },
  {
    path: '/request-password',
    name: 'requestPassword',
    component: RequestPassword,
    meta: {
      requiresGuest: true
    }
  },
  {
    path: '/reset-password/:token',
    name: 'resetPassword',
    component: ResetPassword,
    meta: {
      requiresGuest: true
    }
  },
  {
    path: '/:pathMatch(.*)',
    name: 'notfound',
    component: NotFound,
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth && !store.state.user.token) {
    next({name: 'login'})
  } else if (to.meta.requiresGuest && store.state.user.token) {
    next({name: 'app.dashboard'})
  } else {
    next();
  }

})

export default router;
