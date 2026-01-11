import axiosClient from "../axios";

export function getCurrentUser({commit}, data) {
  return axiosClient.get('/user', data)
    .then(({data}) => {
      commit('setUser', data);
      return data;
    })
}

export function login({commit}, data) {
  return axiosClient.post('/login', data)
    .then(({data}) => {
      commit('setUser', data.user);
      commit('setToken', data.token)
      return data;
    })
}

export function logout({commit}) {
  return axiosClient.post('/logout')
    .then((response) => {
      commit('setToken', null)

      return response;
    })
}

export function getCountries({commit}) {
  return axiosClient.get('countries')
    .then(({data}) => {
      commit('setCountries', data)
    })
}

export function getOrders({commit, state}, {url = null, search = '', per_page, sort_field, sort_direction} = {}) {
  commit('setOrders', [true])
  url = url || '/orders'
  const params = {
    per_page: state.orders.limit,
  }
  return axiosClient.get(url, {
    params: {
      ...params,
      search, per_page, sort_field, sort_direction
    }
  })
    .then((response) => {
      commit('setOrders', [false, response.data])
    })
    .catch(() => {
      commit('setOrders', [false])
    })
}

export function getOrder({commit}, id) {
  return axiosClient.get(`/orders/${id}`)
}

// HOMEHEROBANNERS
export function getHomeHeroBanners({commit, state}, {url = null, search = '', per_page, sort_field, sort_direction} = {}) {
  commit('setHomeHeroBanners', [true])
  url = url || '/homeherobanners'
  const params = {
    per_page: state.homeHeroBanners.limit,
  }
  return axiosClient.get(url, {
    params: {
      ...params,
      search, per_page, sort_field, sort_direction
    }
  })
    .then((response) => {
      commit('setHomeHeroBanners', [false, response.data])
    })
    .catch(() => {
      commit('setHomeHeroBanners', [false])
    })
}

export function getHomeHeroBanner({commit}, id) {
  return axiosClient.get(`/homeherobanners/${id}`)
}

export function createHomeHeroBanner({commit}, homeHeroBanner) {
  if (homeHeroBanner.image instanceof File) {
    const form = new FormData();
    form.append('image', homeHeroBanner.image);
    form.append('headline', homeHeroBanner.headline);
    form.append('description', homeHeroBanner.description);
    form.append('short_description', homeHeroBanner.short_description);
    form.append('link', homeHeroBanner.link);

  // Agregar tags al FormData
  if (homeHeroBanner.tags && homeHeroBanner.tags.length) {
    homeHeroBanner.tags.forEach((tag) => {
      form.append(`tags[]`, tag);
    });
  }
    homeHeroBanner = form;
  }
  return axiosClient.post('/homeherobanners', homeHeroBanner)
}

export function updateHomeHeroBanner({commit}, homeHeroBanner) {
  const id = homeHeroBanner.id
  if (homeHeroBanner.image instanceof File) {
    const form = new FormData();
    form.append('id', homeHeroBanner.id);
    form.append('image', homeHeroBanner.image);
    form.append('headline', homeHeroBanner.headline);
    form.append('description', homeHeroBanner.description);
    form.append('short_description', homeHeroBanner.short_description);
    form.append('link', homeHeroBanner.link);
    form.append('_method', 'PUT');
    // Agregar tags al FormData
    if (homeHeroBanner.tags && homeHeroBanner.tags.length) {
      homeHeroBanner.tags.forEach((tag) => {
        form.append(`tags[]`, tag);
      });
    }
    homeHeroBanner = form;
  } else {
    homeHeroBanner._method = 'PUT'
  }
  return axiosClient.post(`/homeherobanners/${id}`, homeHeroBanner)
}

export function deleteHomeHeroBanner({commit}, id) {
  return axiosClient.delete(`/homeherobanners/${id}`)
}

// CATEGORIES
export function getCategories({commit, state}, {sort_field, sort_direction} = {}) {
  commit('setCategories', [true])
  return axiosClient.get('/categories', {
    params: {
      sort_field, sort_direction
    }
  })
    .then((response) => {
      commit('setCategories', [false, response.data])
    })
    .catch(() => {
      commit('setCategories', [false])
    })
}

export function getCategory({commit}, id) {
  return axiosClient.get(`/categories/${id}`)
}

export function createCategory({commit}, category) {
  if (category.image instanceof File) {
    const form = new FormData();
    form.append('name', category.name);
    form.append('description', category.description);
    form.append('image', category.image);
    form.append('active', category.active ? 1 : 0);
    category = form;
  }
  return axiosClient.post('/categories', category)
}

export function updateCategory({commit}, category) {
  const id = category.id
  if (category.image instanceof File) {
    const form = new FormData();
    form.append('id', category.id);
    form.append('name', category.name);
    form.append('description', category.description);
    form.append('image', category.image);
    form.append('active', category.active ? 1 : 0);
    form.append('_method', 'PUT');
    category = form;
  } else {
    category._method = 'PUT'
  }
  return axiosClient.post(`/categories/${id}`, category)
}

export function deleteCategory({commit}, id) {
  return axiosClient.delete(`/categories/${id}`)
}

// PRODUCTS
export function getProducts({commit, state}, {url = null, search = '', per_page, sort_field, sort_direction} = {}) {
  commit('setProducts', [true])
  url = url || '/products'
  const params = {
    per_page: state.products.limit,
  }
  return axiosClient.get(url, {
    params: {
      ...params,
      search, per_page, sort_field, sort_direction
    }
  })
    .then((response) => {
      commit('setProducts', [false, response.data])
    })
    .catch(() => {
      commit('setProducts', [false])
    })
}

export function getProduct({commit}, id) {
  return axiosClient.get(`/products/${id}`)
}

export function createProduct({ commit }, product) {
  const form = new FormData();

  form.append('title', product.title);
  form.append('short_description', product.short_description || '');
  form.append('description', product.description || '');
  form.append('leading_home', product.leading_home ? 1 : 0);
  form.append('leading_category', product.leading_category ? 1 : 0);
  form.append('client_number', product.client_number || '');
  form.append('urgencies', product.urgencies ? 1 : 0);
  form.append('published', product.published ? 1 : 0);

  
  // Agregar categorías al FormData
  if (product.categories && product.categories.length) {
    product.categories.forEach((category) => {
      form.append(`categories[]`, category);
    });
  }
  // Lógica para farmacia
  const PHARMACY_CATEGORY_ID = 88
  const isPharmacy = product.categories?.some(catId => catId == PHARMACY_CATEGORY_ID)

  if (isPharmacy && product.pharmacy_shifts?.length) {
    product.pharmacy_shifts.forEach((shift, index) => {
      form.append(`pharmacy_shifts[${index}][shift_date]`, shift.shift_date)
      form.append(`pharmacy_shifts[${index}][start_time]`, shift.start_time)
      form.append(`pharmacy_shifts[${index}][end_time]`, shift.end_time)
    })
  }

  // Agregar imágenes al FormData
  if (product.images && product.images.length) {
    product.images.forEach((im) => {
      form.append(`images[]`, im);
    });
  }
  
  if (product.contacts && product.contacts.length) {
    product.contacts.forEach((contact, index) => {
      form.append(`contacts[${index}][type]`, contact.type);
      form.append(`contacts[${index}][info]`, contact.info);
    });
  }

  if (product.socials && product.socials.length) {
    product.socials.forEach((social, index) => {
      form.append(`socials[${index}][rrss]`, social.rrss);
      form.append(`socials[${index}][link]`, social.link);
    });
  }

  if (product.addresses && product.addresses.length) {
    product.addresses.forEach((address, index) => {
      form.append(`addresses[${index}][title]`, address.title || '');
      form.append(`addresses[${index}][via]`, address.via || '');
      form.append(`addresses[${index}][via_name]`, address.via_name || '');
      form.append(`addresses[${index}][via_number]`, address.via_number || '');
      form.append(`addresses[${index}][address_unit]`, address.address_unit || '');
      form.append(`addresses[${index}][city]`, address.city || '');
      form.append(`addresses[${index}][zip_code]`, address.zip_code || '');
      form.append(`addresses[${index}][province]`, address.province || '');
      form.append(`addresses[${index}][link]`, address.link || '');
      form.append(`addresses[${index}][google_maps]`, address.google_maps || '');
    });
  }

  // Agregar tags al FormData
  if (product.tags && product.tags.length) {
    product.tags.forEach((tag) => {
      form.append(`tags[]`, tag);
    });
  }

  // Agregar horarios al FormData
  if (product.horarios && product.horarios.length) {
    product.horarios.forEach((horario, index) => {
      form.append(`horarios[${index}][dia]`, horario.dia || '');
      form.append(`horarios[${index}][apertura]`, horario.apertura || '');
      form.append(`horarios[${index}][cierre]`, horario.cierre || '');
    });
  }

  // Agregar página web al FormData
  if (product.webs && product.webs.length) {
    product.webs.forEach((web, index) => {
      form.append(`webs[${index}][webpage]`, web.webpage);
    });
  }

  // Agregar Items al FormData
  if (product.listitems && product.listitems.length) {
    product.listitems.forEach((listitem, index) => {
      form.append(`listitems[${index}][item]`, listitem.item);
    });
  }

  return axiosClient.post('/products', form);
}

export function updateProduct({commit}, product) {
  const id = product.id
  if (product.images && product.images.length) {
    const form = new FormData();
    form.append('id', product.id);
    form.append('title', product.title);
    form.append('short_description', product.short_description || '');
    form.append('description', product.description || '');
    form.append('client_number', product.client_number || '');
    form.append('leading_home', product.leading_home ? 1 : 0);
    form.append('leading_category', product.leading_category ? 1 : 0);
    form.append('urgencies', product.urgencies ? 1 : 0);
    form.append('published', product.published ? 1 : 0);
    
  // Agregar categorías al FormData
  if (product.categories && product.categories.length) {
    product.categories.forEach((category) => {
      form.append(`categories[]`, category);
    });
  }

  // Lógica para farmacia
  const PHARMACY_CATEGORY_ID = 88
  const isPharmacy = product.categories?.some(catId => catId == PHARMACY_CATEGORY_ID)

  if (isPharmacy && product.pharmacy_shifts?.length) {
    product.pharmacy_shifts.forEach((shift, index) => {
      form.append(`pharmacy_shifts[${index}][shift_date]`, shift.shift_date)
      form.append(`pharmacy_shifts[${index}][start_time]`, shift.start_time)
      form.append(`pharmacy_shifts[${index}][end_time]`, shift.end_time)
    })
  }
  
  // Agregar imágenes al FormData
  if (product.images && product.images.length) {
    product.images.forEach((im) => {
      form.append(`images[]`, im);
    });
  }
  // Agregar imágenes eliminadas al FormData
  if (product.deleted_images && product.deleted_images.length) {
    product.deleted_images.forEach((id) => form.append('deleted_images[]', id));
  }
  // Agregar posiciones de imágenes al FormData
  for (let id in product.image_positions) {
    form.append(`image_positions[${id}]`, product.image_positions[id]);
  }

  if (product.contacts && product.contacts.length) {
    product.contacts.forEach((contact, index) => {
      form.append(`contacts[${index}][type]`, contact.type);
      form.append(`contacts[${index}][info]`, contact.info);
    });
  }

  if (product.socials && product.socials.length) {
    product.socials.forEach((social, index) => {
      form.append(`socials[${index}][rrss]`, social.rrss);
      form.append(`socials[${index}][link]`, social.link);
    });
  }

  if (product.addresses && product.addresses.length) {
    product.addresses.forEach((address, index) => {
      form.append(`addresses[${index}][title]`, address.title || '');
      form.append(`addresses[${index}][via]`, address.via || '');
      form.append(`addresses[${index}][via_name]`, address.via_name || '');
      form.append(`addresses[${index}][via_number]`, address.via_number || '');
      form.append(`addresses[${index}][address_unit]`, address.address_unit || '');
      form.append(`addresses[${index}][city]`, address.city || '');
      form.append(`addresses[${index}][zip_code]`, address.zip_code || '');
      form.append(`addresses[${index}][province]`, address.province || '');
      form.append(`addresses[${index}][link]`, address.link || '');
      form.append(`addresses[${index}][google_maps]`, address.google_maps || '');
    });
  }

  // Agregar tags al FormData
  if (product.tags && product.tags.length) {
    product.tags.forEach((tag) => {
      form.append(`tags[]`, tag);
    });
  }

  // Agregar horarios al FormData
  if (product.horarios && product.horarios.length) {
    product.horarios.forEach((horario, index) => {
      form.append(`horarios[${index}][dia]`, horario.dia || '');
      form.append(`horarios[${index}][apertura]`, horario.apertura || '');
      form.append(`horarios[${index}][cierre]`, horario.cierre || '');
    });
  }

  // Agregar página web al FormData
  if (product.webs && product.webs.length) {
    product.webs.forEach((web, index) => {
      form.append(`webs[${index}][webpage]`, web.webpage);
    });
  }

  // Agregar Items al FormData
  if (product.listitems && product.listitems.length) {
    product.listitems.forEach((listitem, index) => {
      form.append(`listitems[${index}][item]`, listitem.item);
    });
  }
  
    form.append('_method', 'PUT');
    product = form;
  } else {
    product._method = 'PUT'
  }
  return axiosClient.post(`/products/${id}`, product)
}

export function deleteProduct({commit}, id) {
  return axiosClient.delete(`/products/${id}`)
}

// REVIEWS
export function getReviews({commit, state}, {url = null, search = '', per_page, sort_field, sort_direction} = {}) {
  commit('setReviews', [true])
  url = url || '/reviews'
  const params = {
    per_page: state.reviews.limit,
  }
  return axiosClient.get(url, {
    params: {
      ...params,
      search, per_page, sort_field, sort_direction
    }
  })
    .then((response) => {
      commit('setReviews', [false, response.data])
    })
    .catch(() => {
      commit('setReviews', [false])
    })
}

export function getReview({commit}, id) {
  return axiosClient.get(`/reviews/${id}`)
}

export function creatReview({commit}, review) {
    const form = new FormData();
    form.append('product_id', review.product_id);
    form.append('name', review.name);
    form.append('last_name', review.last_name);
    form.append('email', review.email);
    form.append('rating', review.rating);
    form.append('title', review.title || '');
    form.append('comment', review.comment || '');
    form.append('token', review.token || '');
    form.append('email_verified', review.email_verified ? 1 : 0);
    form.append('published', review.published ? 1 : 0);
    form.append('created_by', review.created_by || '');
    form.append('updated_by', review.updated_by || '');
    form.append('admin_response', review.admin_response || '');
    review = form;

  return axiosClient.post('/reviews', review)
}

export function updateReview({ commit }, review) {
  const id = review.id;
  const form = new FormData();
    form.append('product_id', review.product_id);
    form.append('name', review.name);
    form.append('last_name', review.last_name);
    form.append('email', review.email);
    form.append('rating', review.rating);
    form.append('title', review.title || '');
    form.append('comment', review.comment || '');
    form.append('token', review.token || '');
    form.append('email_verified', review.email_verified ? 1 : 0);
    form.append('published', review.published ? 1 : 0);
    form.append('created_by', review.created_by || '');
    form.append('updated_by', review.updated_by || '');
    form.append('admin_response', review.admin_response || '');
    form.append('_method', 'PUT');
  // Agregamos el método override para que Laravel lo interprete como PUT
  review._method = 'PUT';

  return axiosClient.post(`/reviews/${id}`, review);
}

export function deleteReview({commit}, id) {
  return axiosClient.delete(`/reviews/${id}`)
}

// ARTICLES
export function getArticles({commit, state}, {url = null, search = '', per_page, sort_field, sort_direction} = {}) {
  commit('setArticles', [true])
  url = url || '/articles'
  const params = {
    per_page: state.articles.limit,
  }
  return axiosClient.get(url, {
    params: {
      ...params,
      search, per_page, sort_field, sort_direction
    }
  })
    .then((response) => {
      commit('setArticles', [false, response.data])
    })
    .catch(() => {
      commit('setArticles', [false])
    })
}

export function getArticle({commit}, id) {
  return axiosClient.get(`/articles/${id}`)
}

export function createArticle({ commit }, article) {
  const form = new FormData();

  form.append('title', article.title);
  form.append('subtitle', article.subtitle || '');
  form.append('news_lead', article.news_lead || '');
  form.append('description', article.description || '');
  form.append('published', article.published ? 1 : 0);

  // Agregar imágenes al FormData
  if (article.images && article.images.length) {
    article.images.forEach((im) => {
      form.append(`images[]`, im);
    });
  }

  // Agregar alérgenos al FormData
  if (article.authors && article.authors.length) {
    article.authors.forEach((author) => {
      form.append(`authors[]`, author);
    });
  }

  // Agregar tags al FormData
  if (article.tags && article.tags.length) {
    article.tags.forEach((tag) => {
      form.append(`tags[]`, tag);
    });
  }

  // Agregar Items al FormData
  if (article.items && article.items.length) {
    article.items.forEach((item, index) => {
      form.append(`items[${index}][texto]`, item.texto);
    });
  }
  
  return axiosClient.post('/articles', form);
}


export function updateArticle({commit}, article) {
  const id = article.id
  if (article.images && article.images.length) {
    const form = new FormData();
    form.append('id', article.id);
    form.append('title', article.title);
    form.append('subtitle', article.subtitle || '');
    form.append('news_lead', article.news_lead || '');
    form.append('description', article.description || '');
    form.append('published', article.published ? 1 : 0);

  // Agregar authores al FormData
  if (article.authors && article.authors.length) {
    article.authors.forEach((author) => {
      form.append(`authors[]`, author);
    });
  }

  // Agregar tags al FormData
  if (article.tags && article.tags.length) {
    article.tags.forEach((tag) => {
      form.append(`tags[]`, tag);
    });
  }
  
  // Agregar imágenes al FormData
  if (article.images && article.images.length) {
    article.images.forEach((im) => {
      form.append(`images[]`, im);
    });
  }

  // Agregar Items al FormData
  if (article.items && article.items.length) {
    article.items.forEach((item, index) => {
      form.append(`items[${index}][texto]`, item.texto);
    });
  }
  
  // Agregar imágenes eliminadas al FormData
  if (article.deleted_images && article.deleted_images.length) {
    article.deleted_images.forEach((id) => form.append('deleted_images[]', id));
  }
  // Agregar posiciones de imágenes al FormData
  for (let id in article.image_positions) {
    form.append(`image_positions[${id}]`, article.image_positions[id]);
  }
  form.append('_method', 'PUT');
  article = form;
  } else {
    article._method = 'PUT'
  }
  return axiosClient.post(`/articles/${id}`, article)
}

export function deleteArticle({commit}, id) {
  return axiosClient.delete(`/articles/${id}`)
}

// AUTHOR
export function getAuthors({commit, state}, {sort_field, sort_direction} = {}) {
  commit('setAuthors', [true])
  return axiosClient.get('/authors', {
    params: {
      sort_field, sort_direction
    }
  })
    .then((response) => {
      commit('setAuthors', [false, response.data])
    })
    .catch(() => {
      commit('setAuthors', [false])
    })
}

export function getAuthor({commit}, id) {
  return axiosClient.get(`/authors/${id}`)
}

export function createAuthor({commit}, author) {
  if (author.image instanceof File) {
    const form = new FormData();
    form.append('name', author.name);
    form.append('image', author.image);
    form.append('description', author.description);
    form.append('active', author.active ? 1 : 0);
    author = form;
  }
  return axiosClient.post('/authors', author)
}


export function updateAuthor({commit}, author) {
  const id = author.id
  if (author.image instanceof File) {
    const form = new FormData();
    form.append('id', author.id);
    form.append('name', author.name);
    form.append('image', author.image);
    form.append('description', author.description);
    form.append('active', author.active ? 1 : 0);
    form.append('_method', 'PUT');
    author = form;
  } else {
    author._method = 'PUT'
  }
  return axiosClient.post(`/authors/${id}`, author)
}


export function deleteAuthor({commit}, id) {
  return axiosClient.delete(`/authors/${id}`)
}

// USERS
export function getUsers({commit, state}, {url = null, search = '', per_page, sort_field, sort_direction} = {}) {
  commit('setUsers', [true])
  url = url || '/users'
  const params = {
    per_page: state.users.limit,
  }
  return axiosClient.get(url, {
    params: {
      ...params,
      search, per_page, sort_field, sort_direction
    }
  })
    .then((response) => {
      commit('setUsers', [false, response.data])
    })
    .catch(() => {
      commit('setUsers', [false])
    })
}

export function createUser({commit}, user) {
  return axiosClient.post('/users', user)
}

export function updateUser({commit}, user) {
  return axiosClient.put(`/users/${user.id}`, user)
}

export function getCustomers({commit, state}, {url = null, search = '', per_page, sort_field, sort_direction} = {}) {
  commit('setCustomers', [true])
  url = url || '/customers'
  const params = {
    per_page: state.customers.limit,
  }
  return axiosClient.get(url, {
    params: {
      ...params,
      search, per_page, sort_field, sort_direction
    }
  })
    .then((response) => {
      commit('setCustomers', [false, response.data])
    })
    .catch(() => {
      commit('setCustomers', [false])
    })
}

export function getCustomer({commit}, id) {
  return axiosClient.get(`/customers/${id}`)
}

export function createCustomer({commit}, customer) {
  return axiosClient.post('/customers', customer)
}

export function updateCustomer({commit}, customer) {
  return axiosClient.put(`/customers/${customer.id}`, customer)
}

export function deleteCustomer({commit}, customer) {
  return axiosClient.delete(`/customers/${customer.id}`)
}

//ALERGENS
export function getAlergens({commit, state}, {sort_field, sort_direction} = {}) {
  commit('setAlergens', [true])
  return axiosClient.get('/alergens', {
    params: {
      sort_field, sort_direction
    }
  })
    .then((response) => {
      commit('setAlergens', [false, response.data])
    })
    .catch(() => {
      commit('setAlergens', [false])
    })
}

export function createAlergen({commit}, alergen) {
  if (alergen.image instanceof File) {
    const form = new FormData();
    form.append('name', alergen.name);
    form.append('image', alergen.image);
    form.append('active', alergen.active ? 1 : 0);
    alergen = form;
  }
  return axiosClient.post('/alergens', alergen)
}

export function updateAlergen({commit}, alergen) {
  const id = alergen.id
  if (alergen.image instanceof File) {
    const form = new FormData();
    form.append('name', alergen.name);
    form.append('image', alergen.image);
    form.append('active', alergen.active ? 1 : 0);
    form.append('_method', 'PUT');
    alergen = form;
  } else {
    alergen._method = 'PUT'
  }
  return axiosClient.post(`/alergens/${id}`, alergen)
}

export function deleteAlergen({commit}, alergen) {
  return axiosClient.delete(`/alergens/${alergen.id}`)
}

// SERVICES
export function getServices({commit, state}, {sort_field, sort_direction} = {}) {
  commit('setServices', [true])
  return axiosClient.get('/services', {
    params: {
      sort_field, sort_direction
    }
  })
    .then((response) => {
      commit('setServices', [false, response.data])
    })
    .catch(() => {
      commit('setServices', [false])
    })
}

export function createService({commit}, service) {
  if (service.image instanceof File) {
    const form = new FormData();
    form.append('name', service.name);
    form.append('icon', service.icon);
    form.append('active', service.active ? 1 : 0);
    form.append('short_description', service.short_description);
    form.append('description', service.description);
    // Agregar atributos al FormData
    if (service.attributes && service.attributes.length) {
      service.attributes.forEach((attribute, index) => {
        form.append(`attributes[${index}][text]`, attribute.text);
      });
    }
    form.append('image', service.image);
    service = form;
  }
  return axiosClient.post('/services', service)
}

export function updateService({commit}, service) {
  const id = service.id
  if (service.image instanceof File) {
    const form = new FormData();
    form.append('name', service.name);
    form.append('icon', service.icon);
    form.append('active', service.active ? 1 : 0);
    form.append('short_description', service.short_description);
    form.append('description', service.description);
    // Agregar atributos al FormData
    if (service.attributes && service.attributes.length) {
      service.attributes.forEach((attribute, index) => {
        form.append(`attributes[${index}][text]`, attribute.text);
      });
    }
    form.append('image', service.image);
    form.append('_method', 'PUT');
    service = form;
  } else {
    service._method = 'PUT'
  }
  return axiosClient.post(`/services/${id}`, service)
}

export function deleteService({commit}, service) {
  return axiosClient.delete(`/services/${service.id}`)
}

// PROJECTS
export function getProjects({commit, state}, {url = null, search = '', per_page, sort_field, sort_direction} = {}) {
  commit('setProjects', [true])
  url = url || '/projects'
  const params = {
    per_page: state.projects.limit,
  }
  return axiosClient.get(url, {
    params: {
      ...params,
      search, per_page, sort_field, sort_direction
    }
  })
    .then((response) => {
      commit('setProjects', [false, response.data])
    })
    .catch(() => {
      commit('setProjects', [false])
    })
}

export function getProject({commit}, id) {
  return axiosClient.get(`/projects/${id}`)
}

export function createProject({ commit }, project) {
  const form = new FormData();

  form.append('title', project.title);
  form.append('description', project.description || '');
  form.append('published', project.published ? 1 : 0);

  // Agregar imágenes al FormData
  if (project.images && project.images.length) {
    project.images.forEach((im) => {
      form.append(`images[]`, im);
    });
  }

  // Agregar services al FormData
  if (project.services && project.services.length) {
    project.services.forEach((service) => {
      form.append(`services[]`, service);
    });
  }

  // Agregar tags al FormData
  if (project.tags && project.tags.length) {
    project.tags.forEach((tag) => {
      form.append(`tags[]`, tag);
    });
  }

  // Agregar clients al FormData
  if (project.clients && project.clients.length) {
    project.clients.forEach((client) => {
      form.append(`clients[]`, client);
    });
  }

  return axiosClient.post('/projects', form);
}


export function updateProject({commit}, project) {
  const id = project.id
  if (project.images && project.images.length) {
    const form = new FormData();
    form.append('id', project.id);
    form.append('title', project.title);
    form.append('description', project.description || '');
    form.append('published', project.published ? 1 : 0);
    
    // Agregar services al FormData
    if (project.services && project.services.length) {
      project.services.forEach((service) => {
        form.append(`services[]`, service);
      });
    }

    // Agregar tags al FormData
    if (project.tags && project.tags.length) {
      project.tags.forEach((tag) => {
        form.append(`tags[]`, tag);
      });
    }

    // Agregar clients al FormData
    if (project.clients && project.clients.length) {
      project.clients.forEach((client) => {
        form.append(`clients[]`, client);
      });
    }

    // Agregar imágenes al FormData
    if (project.images && project.images.length) {
      project.images.forEach((im) => {
        form.append(`images[]`, im);
      });
    }

    // Agregar imágenes eliminadas al FormData
    if (project.deleted_images && project.deleted_images.length) {
      project.deleted_images.forEach((id) => form.append('deleted_images[]', id));
    }
    
    // Agregar posiciones de imágenes al FormData
    for (let id in project.image_positions) {
      form.append(`image_positions[${id}]`, project.image_positions[id]);
    }
    form.append('_method', 'PUT');
    project = form;
  } else {
    project._method = 'PUT'
  }
  return axiosClient.post(`/projects/${id}`, project)
}

export function deleteProject({commit}, id) {
  return axiosClient.delete(`/projects/${id}`)
}

//TAGS
export function getTags({commit, state}, {url = null, search = '', per_page, sort_field, sort_direction} = {}) {
  commit('setTags', [true])
  url = url || '/tags'
  const params = {
    per_page: state.tags.limit,
  }
  return axiosClient.get(url, {
    params: {
      ...params,
      search, per_page, sort_field, sort_direction
    }
  })
    .then((response) => {
      commit('setTags', [false, response.data])
    })
    .catch(() => {
      commit('setTags', [false])
    })
}

export function createTag({commit}, tag) {
  if (tag.image instanceof File) {
    const form = new FormData();
    form.append('name', tag.name);
    form.append('image', tag.image);
    form.append('active', tag.active ? 1 : 0);
    tag = form;
  }
  return axiosClient.post('/tags', tag)
}

export function updateTag({commit}, tag) {
  const id = tag.id
  if (tag.image instanceof File) {
    const form = new FormData();
    form.append('name', tag.name);
    form.append('image', tag.image);
    form.append('active', tag.active ? 1 : 0);
    form.append('_method', 'PUT');
    tag = form;
  } else {
    tag._method = 'PUT'
  }
  return axiosClient.post(`/tags/${id}`, tag)
}

export function deleteTag({commit}, tag) {
  return axiosClient.delete(`/tags/${tag.id}`)
}

//CLIENTS
export function getClients({commit, state}, {sort_field, sort_direction} = {}) {
  commit('setClients', [true])
  return axiosClient.get('/clients', {
    params: {
      sort_field, sort_direction
    }
  })
    .then((response) => {
      commit('setClients', [false, response.data])
    })
    .catch(() => {
      commit('setClients', [false])
    })
}

export function createClient({commit}, client) {
  if (client.image instanceof File) {
    const form = new FormData();
    form.append('name', client.name);
    form.append('image', client.image);
    form.append('active', client.active ? 1 : 0);
    client = form;
  }
  return axiosClient.post('/clients', client)
}

export function updateClient({commit}, client) {
  const id = client.id
  if (client.image instanceof File) {
    const form = new FormData();
    form.append('name', client.name);
    form.append('image', client.image);
    form.append('active', client.active ? 1 : 0);
    form.append('_method', 'PUT');
    client = form;
  } else {
    client._method = 'PUT'
  }
  return axiosClient.post(`/clients/${id}`, client)
}

export function deleteClient({commit}, client) {
  return axiosClient.delete(`/clients/${client.id}`)
}