<x-app-layout>
    <x-breadcrumbs breadcrumbs_location="Política de Privacidad" />
    <div class="flex flex-col justify-center gap-12 py-16 container">
        <h1>{{ __('Política de Privacidad') }}</h1>

        <p>{{ __('Última actualización: 23 de noviembre de 2024') }}</p>

        <div class="flex flex-col gap-4">
            <h2>{{ __('1. Información General') }}</h2>
            <p>{{ __('Chimicreativo.es, como responsable del tratamiento de los datos, está comprometido con la privacidad de sus usuarios y garantiza que los datos personales recopilados serán tratados conforme al Reglamento General de Protección de Datos (RGPD) y demás normativas aplicables.') }}</p>
        </div>

        <div class="flex flex-col gap-4">
            <h2>{{ __('2. Datos Recopilados') }}</h2>
            
            <p>{{ __('Recopilamos los siguientes datos personales a través de nuestros formularios:') }}</p>

            <div>
                <p class="strong">{{ __('Formulario de Contacto:') }}</p>
                <ul class="list-disc pl-12">
                    <li>{{ __('Nombre') }}</li>
                    <li>{{ __('Correo electrónico') }}</li>
                    <li>{{ __('Teléfono') }}</li>
                    <li>{{ __('Servicio solicitado (Diseño gráfico, Desarrollo web, Branding)') }}</li>
                    <li>{{ __('Mensaje') }}</li>
                </ul>
            </div>
            
            <div>
                <p class="strong">{{ __('Formulario de Presupuesto:') }}</p>
                <ul class="list-disc pl-12">
                    <li>{{ __('Nombre') }}</li>
                    <li>{{ __('Correo electrónico') }}</li>
                    <li>{{ __('Teléfono') }}</li>
                    <li>{{ __('Detalles del servicio solicitado') }}</li>
                    <li>{{ __('Mensaje') }}</li>
                </ul>
            </div>

            <div>
                <p class="strong">{{ __('Automáticamente a través de cookies:') }}</p>
                <ul class="list-disc pl-12">
                    <li>{{ __('Datos de navegación (dirección IP, dispositivo, tiempo de visita).') }}</li>
                    <li>{{ __('Cookies: XSRF-TOKEN, _ga, _ga_9Q6H0QETRF, chimi_creativo_session, laravel_cookie_consent, ls_smartpush.') }}</li>
                </ul>
            </div>
        </div>

        <div class="flex flex-col gap-4">
            <h2>{{ __('3. Finalidad del Tratamiento') }}</h2>
            
            <p>{{ __('Los datos personales serán utilizados para:') }}</p>

            <ul class="list-disc pl-12">
                <li>{{ __('Responder consultas y solicitudes de contacto.') }}</li>
                <li>{{ __('Gestionar presupuestos.') }}</li>
                <li>{{ __('Mejorar el rendimiento del sitio web mediante análisis estadísticos.') }}</li>
                <li>{{ __('Garantizar la seguridad del sitio.') }}</li>
                <li>{{ __('Actividades de marketing: Utilizamos los datos personales con fines de marketing, incluyendo:') }}
                    <ul class="list-decimal pl-12">
                        <li>{{ __('Email marketing: Enviar boletines informativos, actualizaciones y promociones relacionadas con nuestros servicios.') }}</li>
                        <li>{{ __('Publicidad personalizada: Utilización de datos para crear campañas publicitarias en plataformas como Facebook Ads y Google Ads.') }}</li>
                    </ul>
                </li>
            </ul>
            <p>{{ __('Los datos no serán compartidos con terceros fuera de estos fines.') }}</p>
        </div>
        
        <div class="flex flex-col gap-4">
            <h2>{{ __('4. Uso de Cookies') }}</h2>
            
            <p>{{ __('En Chimicreativo.es utilizamos cookies para:') }}</p>

            <ul class="list-disc pl-12">
                <li>{{ __('Mejorar la experiencia del usuario.') }}</li>
                <li>{{ __('Realizar análisis de tráfico (Google Analytics).') }}</li>
                <li>{{ __('Personalización de anuncios (para campañas de publicidad en Facebook y Google).') }}</li>
            </ul>
            <p>{{ __('Puedes gestionar las cookies desde el banner inicial o configurando tu navegador.') }}</p>
        </div>
        
        <div class="flex flex-col gap-4">
            <h2>{{ __('5. Base Legal para el Tratamiento') }}</h2>
            <ul class="list-disc pl-12">
                <li>{{ __('Consentimiento explícito del usuario al suscribirse a nuestros boletines o aceptar recibir publicidad personalizada.') }}</li>
                <li>{{ __('Cumplimiento de obligaciones legales.') }}</li>
                <li>{{ __('Intereses legítimos para mejorar nuestro sitio y servicios.') }}</li>
            </ul>
        </div>
        
        <div class="flex flex-col gap-4">
            <h2>{{ __('6. Conservación de los Datos') }}</h2>
            <p>{{ __('Los datos personales serán conservados mientras sean necesarios para las finalidades descritas, o hasta que el usuario solicite su eliminación.') }}</p>
        </div>

        <div class="flex flex-col gap-4">
            <h2>{{ __('7. Derechos de los Usuarios') }}</h2>

            <p>{{ __('Los usuarios tienen derecho a:') }}</p>

            <ul class="list-disc pl-12">
                <li>{{ __('Acceder a sus datos personales.') }}</li>
                <li>{{ __('Rectificar datos incorrectos.') }}</li>
                <li>{{ __('Solicitar la eliminación de sus datos.') }}</li>
                <li>{{ __('Limitar el tratamiento.') }}</li>
                <li>{{ __('Revocar el consentimiento otorgado.') }}</li>
            </ul>

            <p>{{ __('Para ejercer tus derechos, puedes escribirnos a: ') }}<a href="mailto:privacidad@chimicreativo.es">privacidad@chimicreativo.es</a>.</p>
        </div>

        <div class="flex flex-col gap-4">
            <h2>{{ __('8. Medidas de Seguridad') }}</h2>

            <p>{{ __('El sitio está protegido mediante:') }}</p>

            <ul class="list-disc pl-12">
                <li>{{ __('Certificado SSL para cifrar las comunicaciones.') }}</li>
                <li>{{ __('Almacenamiento en servidores seguros de Hostinger.') }}</li>
                <li>{{ __('Copias de seguridad periódicas.') }}</li>
            </ul>
        </div>
        
        <div class="flex flex-col gap-4">
            <h2>{{ __('9. Modificaciones') }}</h2>

            <p>{{ __('Nos reservamos el derecho de actualizar esta Política de Privacidad en función de cambios legales o técnicos. La fecha de la última actualización aparecerá al inicio del documento.') }}</p>
        </div>

        <div class="flex flex-col gap-4">
            <h2>{{ __('10. Contacto') }}</h2>

            <p>{{ __('Para consultas o solicitudes relacionadas con esta política, contáctanos en: ') }}<a href="mailto:privacidad@chimicreativo.es">privacidad@chimicreativo.es</a>.</p>
        </div>
    </div>
</x-app-layout>
