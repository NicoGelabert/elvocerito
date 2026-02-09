<x-app-layout>
    <x-breadcrumbs breadcrumbs_location="Política de Privacidad" />

    <div class="flex flex-col justify-center gap-12 py-16 container cookie-policy">
        <h1>{{ __('Política de Privacidad – ElVocerito.com') }}</h1>

        <p>{{ __('En El Vocerito valoramos la privacidad de nuestros usuarios y anunciantes. La presente Política de Privacidad describe cómo recopilamos, utilizamos y protegemos los datos personales de quienes acceden y utilizan el sitio web www.elvocerito.com (en adelante, el “Portal”).') }}</p>

        <p>{{ __('El uso del Portal implica la aceptación de esta Política de Privacidad.') }}</p>

        <div class="flex flex-col gap-4">
            <h2>{{ __('1. Responsable del tratamiento de los datos') }}</h2>
            <p>{{ __('El responsable del tratamiento de los datos personales es El Vocerito / ElVocerito.com, con domicilio en la Ciudad de Quilmes, Provincia de Buenos Aires, República Argentina.') }}</p>
        </div>

        <div class="flex flex-col gap-4">
            <h2>{{ __('2. Datos personales que recopilamos') }}</h2>

            <p>{{ __('Podemos recopilar datos personales de los usuarios y anunciantes cuando:') }}</p>

            <ul class="list-disc pl-12">
                <li>{{ __('Se comunican con nosotros por WhatsApp, correo electrónico o formularios del sitio.') }}</li>
                <li>{{ __('Contratan publicidad o solicitan información sobre nuestros servicios.') }}</li>
                <li>{{ __('Publican un aviso o perfil dentro del Portal.') }}</li>
            </ul>

            <p class="strong">{{ __('Los datos pueden incluir:') }}</p>

            <ul class="list-disc pl-12">
                <li>{{ __('Nombre y apellido') }}</li>
                <li>{{ __('DNI') }}</li>
                <li>{{ __('Nombre comercial o razón social') }}</li>
                <li>{{ __('Teléfono y/o WhatsApp') }}</li>
                <li>{{ __('Correo electrónico') }}</li>
                <li>{{ __('Dirección') }}</li>
                <li>{{ __('Imágenes, logotipos o material gráfico') }}</li>
                <li>{{ __('Información relacionada con la actividad o servicio ofrecido') }}</li>
            </ul>
        </div>

        <div class="flex flex-col gap-4">
            <h2>{{ __('3. Finalidad del uso de los datos') }}</h2>

            <ul class="list-disc pl-12">
                <li>{{ __('Gestionar la publicación de avisos y perfiles dentro del Portal.') }}</li>
                <li>{{ __('Facilitar el contacto entre usuarios y anunciantes.') }}</li>
                <li>{{ __('Brindar información sobre nuestros servicios y promociones.') }}</li>
                <li>{{ __('Realizar comunicaciones operativas, comerciales o administrativas.') }}</li>
                <li>{{ __('Mejorar la experiencia de navegación y el funcionamiento del Portal.') }}</li>
                <li>{{ __('Cumplir con obligaciones legales y regulatorias.') }}</li>
            </ul>

            <p>{{ __('El Vocerito no utilizará los datos personales para fines distintos a los aquí detallados sin el consentimiento previo del titular.') }}</p>
        </div>

        <div class="flex flex-col gap-4">
            <h2>{{ __('4. Publicidad y visibilidad de los datos') }}</h2>
            <p>{{ __('Al contratar un aviso o perfil en ElVocerito.com, el anunciante acepta que los datos necesarios para la difusión de su actividad (nombre, servicio, contacto, imágenes, ubicación, etc.) sean publicados de forma visible en el Portal y puedan ser indexados por motores de búsqueda como Google.') }}</p>
        </div>

        <div class="flex flex-col gap-4">
            <h2>{{ __('5. Cesión de datos a terceros') }}</h2>
            <p>{{ __('El Vocerito no vende, alquila ni cede datos personales a terceros, salvo en los siguientes casos:') }}</p>
            <ul class="list-disc pl-12">
                <li>{{ __('Cuando sea necesario para la prestación del Servicio.') }}</li>
                <li>{{ __('Cuando exista una obligación legal o requerimiento judicial.') }}</li>
                <li>{{ __('Cuando el usuario o anunciante haya otorgado su consentimiento expreso.') }}</li>
            </ul>
        </div>

        <div class="flex flex-col gap-4">
            <h2>{{ __('6. Seguridad de la información') }}</h2>
            <p>{{ __('El Vocerito adopta medidas técnicas y organizativas razonables para proteger los datos personales contra pérdida, uso indebido, acceso no autorizado o divulgación.') }}</p>
            <p>{{ __('No obstante, el usuario reconoce que ningún sistema de seguridad es completamente infalible y que el uso de Internet implica ciertos riesgos.') }}</p>
        </div>

        <div class="flex flex-col gap-4">
            <h2>{{ __('7. Derechos de los titulares de los datos') }}</h2>

            <p>{{ __('De acuerdo con la Ley N.º 25.326, los titulares de los datos tienen derecho a:') }}</p>

            <ul class="list-disc pl-12">
                <li>{{ __('Acceder a sus datos personales.') }}</li>
                <li>{{ __('Solicitar la rectificación, actualización o supresión de los mismos.') }}</li>
                <li>{{ __('Retirar su consentimiento cuando corresponda.') }}</li>
            </ul>

            <p>{{ __('La Agencia de Acceso a la Información Pública, órgano de control de la Ley 25.326, tiene la facultad de atender denuncias y reclamos relacionados con el incumplimiento de las normas sobre protección de datos personales.') }}</p>
        </div>

        <div class="flex flex-col gap-4">
            <h2>{{ __('8. Uso de cookies') }}</h2>
            <p>{{ __('El Portal utiliza cookies y tecnologías similares para analizar el comportamiento de navegación, mejorar el funcionamiento del sitio y personalizar contenidos y anuncios.') }}</p>
            <p>{{ __('El usuario puede configurar su navegador para rechazar o eliminar cookies, aunque esto podría afectar algunas funcionalidades del Portal.') }}</p>

            <div class="flex flex-col gap-6">
                <h3>{{ __('Detalle de Cookies Utilizadas') }}</h3>

                <p>{{ __('A continuación se detallan las cookies que pueden instalarse en el dispositivo del usuario al navegar por el Portal:') }}</p>

                <div class="overflow-x-auto">
                    <table class="table-auto w-full text-sm">
                        <thead>
                            <tr class="text-left border-b">
                                <th class="py-2">{{ __('Cookie') }}</th>
                                <th>{{ __('Proveedor') }}</th>
                                <th>{{ __('Finalidad') }}</th>
                                <th>{{ __('Tipo') }}</th>
                                <th>{{ __('Duración') }}</th>
                            </tr>
                        </thead>
                        <tbody class="align-top">

                            <tr class="border-b">
                                <td>el_vocerito_servicios_cerca_tuyo_session</td>
                                <td>El Vocerito</td>
                                <td>{{ __('Mantiene la sesión activa del usuario dentro del sitio.') }}</td>
                                <td>{{ __('Necesaria / Técnica') }}</td>
                                <td>{{ __('Sesión') }}</td>
                            </tr>

                            <tr class="border-b">
                                <td>XSRF-TOKEN</td>
                                <td>El Vocerito</td>
                                <td>{{ __('Protección de formularios y seguridad contra ataques CSRF.') }}</td>
                                <td>{{ __('Seguridad') }}</td>
                                <td>{{ __('Sesión') }}</td>
                            </tr>

                            <tr class="border-b">
                                <td>laravel_cookie_consent</td>
                                <td>El Vocerito</td>
                                <td>{{ __('Recuerda si el usuario aceptó el uso de cookies.') }}</td>
                                <td>{{ __('Necesaria') }}</td>
                                <td>{{ __('Persistente') }}</td>
                            </tr>

                            <tr class="border-b">
                                <td>recently_viewed_categories</td>
                                <td>El Vocerito</td>
                                <td>{{ __('Guarda categorías visitadas recientemente para mejorar la experiencia de navegación.') }}</td>
                                <td>{{ __('Funcional') }}</td>
                                <td>{{ __('Persistente') }}</td>
                            </tr>

                            <tr class="border-b">
                                <td>_ga, _ga_KRY5MKQRS3</td>
                                <td>Google Analytics</td>
                                <td>{{ __('Analizan estadísticas de uso del sitio (visitas, tiempo de permanencia, páginas vistas).') }}</td>
                                <td>{{ __('Analítica') }}</td>
                                <td>{{ __('Hasta 2 años') }}</td>
                            </tr>

                            <tr class="border-b">
                                <td>__Secure-YEC</td>
                                <td>YouTube / Google</td>
                                <td>{{ __('Permite la reproducción e integración de videos de YouTube.') }}</td>
                                <td>{{ __('Servicios externos') }}</td>
                                <td>{{ __('Persistente') }}</td>
                            </tr>

                            <tr class="border-b">
                                <td>APISID, SAPISID, SID, HSID, SSID, SIDCC, NID, AEC, SEARCH_SAMESITE, __Secure-ENID, __Secure-BUCKET</td>
                                <td>Google</td>
                                <td>{{ __('Cookies utilizadas por servicios de Google para seguridad, autenticación, prevención de fraude y preferencias del usuario.') }}</td>
                                <td>{{ __('Seguridad / Terceros') }}</td>
                                <td>{{ __('Persistentes') }}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <p>{{ __('Estas cookies pueden ser propias o de terceros. Algunas son necesarias para el funcionamiento del sitio, mientras que otras permiten mejorar la experiencia del usuario o analizar el uso del Portal.') }}</p>

                <p>{{ __('El usuario puede configurar su navegador para rechazar o eliminar cookies en cualquier momento.') }}</p>
            </div>

        </div>

        <div class="flex flex-col gap-4">
            <h2>{{ __('9. Enlaces a sitios de terceros') }}</h2>
            <p>{{ __('El Portal puede contener enlaces a sitios web de terceros. El Vocerito no es responsable por las políticas de privacidad ni por el contenido de dichos sitios. El acceso a estos enlaces se realiza bajo exclusiva responsabilidad del usuario.') }}</p>
        </div>

        <div class="flex flex-col gap-4">
            <h2>{{ __('10. Cambios en la Política de Privacidad') }}</h2>
            <p>{{ __('El Vocerito se reserva el derecho de modificar esta Política de Privacidad en cualquier momento. Las modificaciones entrarán en vigencia desde su publicación en el Portal. El uso continuado del sitio luego de dichos cambios implica la aceptación de los mismos.') }}</p>
        </div>

        <div class="flex flex-col gap-4">
            <h2>{{ __('11. Legislación aplicable y jurisdicción') }}</h2>
            <p>{{ __('Esta Política de Privacidad se rige por las leyes de la República Argentina. Para cualquier controversia, las partes se someten a la jurisdicción de los Tribunales Ordinarios con asiento en la Ciudad de Quilmes, Provincia de Buenos Aires.') }}</p>
        </div>
    </div>
</x-app-layout>
