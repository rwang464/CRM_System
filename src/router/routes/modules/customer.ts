import { DEFAULT_LAYOUT } from '../base';
import { AppRouteRecordRaw } from '../types';

const customerRoutes: AppRouteRecordRaw = {
  path: '/customer',
  name: 'customer',
  component: DEFAULT_LAYOUT,
  meta: {
    locale: 'menu.customer',
    requiresAuth: true,
    icon: 'icon-list',
    order: 2,
  },
  children: [
    {
      path: 'search-table', // The midline path complies with SEO specifications
      name: 'SearchTable',
      component: () => import('@/views/customer/search-table/index.vue'),
      meta: {
        locale: 'menu.customer.searchTable',
        requiresAuth: true,
        roles: ['*'],
      },
      children: [
        {
          path: 'BasicInfo',
          name: 'BasicInfo', // 为目标页面指定一个路由名称
          component: () =>
            import('@/views/customer/search-table/BasicInfo.vue'),
        },
      ],
    },
  ],
};

const pdfViewerRoute: AppRouteRecordRaw = {
  path: '/pdf-viewer',
  name: 'PDFViewer',
  component: () =>
    import('@/views/customer/search-table/components/PDFPreview.vue'),
  meta: {
    locale: 'menu.customer',
    requiresAuth: true,
    hidden: true,
  },
};

const routes: AppRouteRecordRaw[] = [customerRoutes, pdfViewerRoute];

export default routes;
