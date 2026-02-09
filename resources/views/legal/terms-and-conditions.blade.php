<x-app-layout>
    <x-breadcrumbs breadcrumbs_location="Términos y Condiciones" />

    <div class="flex flex-col justify-center gap-12 py-16 container legal-page">
        <h1>{{ __('Términos y Condiciones – ElVocerito.com') }}</h1>

        <div class="flex flex-col gap-4">
            <h2>{{ __('1. Aceptación de los Términos') }}</h2>
            <p>{{ __('El acceso, navegación y uso del portal www.elvocerito.com (en adelante, el “Portal” o “ElVocerito.com”) implica la aceptación plena y sin reservas de los presentes Términos y Condiciones.') }}</p>
            <p>{{ __('El uso del Portal está destinado tanto a usuarios como a anunciantes, quienes quedarán sujetos a las disposiciones aquí establecidas.') }}</p>
            <p>{{ __('ElVocerito.com podrá modificar estos Términos en cualquier momento. Las modificaciones entrarán en vigencia desde su publicación en el Portal. El uso continuado del Portal implica la aceptación de los cambios.') }}</p>
        </div>

        <div class="flex flex-col gap-4">
            <h2>{{ __('2. Servicios ofrecidos') }}</h2>
            <p>{{ __('El Portal brinda un servicio de información y comunicación en línea, permitiendo la publicación, difusión y consulta de anuncios y contenidos de terceros.') }}</p>
            <p>{{ __('El acceso y utilización del Servicio está condicionado a la aceptación de los presentes Términos.') }}</p>
        </div>

        <div class="flex flex-col gap-4">
            <h2>{{ __('3. Responsabilidad sobre la información publicada') }}</h2>
            <p>{{ __('La información disponible proviene de diversas fuentes, incluyendo aportes de los anunciantes.') }}</p>
            <p>{{ __('ElVocerito.com no garantiza la exactitud, veracidad, integridad ni actualización de la información publicada.') }}</p>
            <p>{{ __('Los reclamos deberán dirigirse directamente contra el anunciante correspondiente, liberando a ElVocerito.com de responsabilidad.') }}</p>
        </div>

        <div class="flex flex-col gap-4">
            <h2>{{ __('4. Relación entre Usuarios y Anunciantes') }}</h2>
            <p>{{ __('Las transacciones se realizan directamente entre usuarios y anunciantes, sin intervención del Portal.') }}</p>
            <ul class="list-disc pl-12">
                <li>{{ __('Calidad, estado, legalidad o entrega de productos o servicios.') }}</li>
                <li>{{ __('Incumplimientos contractuales entre las partes.') }}</li>
                <li>{{ __('Exactitud de precios o descripciones.') }}</li>
                <li>{{ __('Solvencia o idoneidad de usuarios o anunciantes.') }}</li>
                <li>{{ __('Veracidad de publicidad de terceros.') }}</li>
                <li>{{ __('Seguridad de pagos externos al Portal.') }}</li>
            </ul>
        </div>

        <div class="flex flex-col gap-4">
            <h2>{{ __('5. Condiciones para anunciantes') }}</h2>
            <p>{{ __('El anunciante declara que la información publicada es veraz y que posee las habilitaciones necesarias.') }}</p>
            <p>{{ __('Es el único responsable por el contenido de su aviso.') }}</p>
            <p>{{ __('ElVocerito.com podrá rechazar o eliminar publicaciones sin generar derecho a indemnización.') }}</p>
            <p>{{ __('La publicación no implica relación laboral ni societaria con ElVocerito.com.') }}</p>
            <p>{{ __('El anunciante autoriza el uso promocional de su nombre, logotipo e imágenes mientras dure la publicación.') }}</p>
        </div>

        <div class="flex flex-col gap-4">
            <h2>{{ __('6. Contenidos de terceros y enlaces externos') }}</h2>
            <p>{{ __('El Portal puede contener enlaces a sitios de terceros. ElVocerito.com no controla ni respalda dichos sitios.') }}</p>
            <p>{{ __('El acceso a sitios externos es responsabilidad exclusiva del usuario.') }}</p>
        </div>

        <div class="flex flex-col gap-4">
            <h2>{{ __('7. Equipamiento y acceso') }}</h2>
            <p>{{ __('El acceso requiere dispositivos y conexión a Internet bajo responsabilidad del usuario.') }}</p>
            <p>{{ __('ElVocerito.com no se responsabiliza por fallas técnicas o interrupciones.') }}</p>
        </div>

        <div class="flex flex-col gap-4">
            <h2>{{ __('8. Propiedad intelectual') }}</h2>
            <p>{{ __('Los contenidos del Portal están protegidos por las leyes de propiedad intelectual de la República Argentina.') }}</p>
            <p>{{ __('Queda prohibida su reproducción sin autorización escrita.') }}</p>
        </div>

        <div class="flex flex-col gap-4">
            <h2>{{ __('9. Datos personales y cookies') }}</h2>
            <p>{{ __('El tratamiento de datos se realiza conforme a la Ley N.º 25.326.') }}</p>
            <p>{{ __('Los usuarios pueden consultar la Política de Privacidad para más información.') }}</p>
        </div>

        <div class="flex flex-col gap-4">
            <h2>{{ __('10. Conducta del usuario') }}</h2>
            <ul class="list-disc pl-12">
                <li>{{ __('No publicar contenidos falsos o ilegales.') }}</li>
                <li>{{ __('No infringir derechos de terceros.') }}</li>
                <li>{{ __('No utilizar el Portal con fines fraudulentos.') }}</li>
            </ul>
        </div>

        <div class="flex flex-col gap-4">
            <h2>{{ __('11. Limitación de responsabilidad') }}</h2>
            <p>{{ __('ElVocerito.com no garantiza disponibilidad continua del Servicio.') }}</p>
        </div>

        <div class="flex flex-col gap-4">
            <h2>{{ __('12. Indemnidad') }}</h2>
            <p>{{ __('El usuario mantendrá indemne a ElVocerito.com frente a reclamos derivados de su uso del Portal.') }}</p>
        </div>

        <div class="flex flex-col gap-4">
            <h2>{{ __('13. Edad mínima') }}</h2>
            <p>{{ __('El uso del Portal está permitido solo a mayores de 18 años.') }}</p>
        </div>

        <div class="flex flex-col gap-4">
            <h2>{{ __('14. Vigencia y nulidad parcial') }}</h2>
            <p>{{ __('La inactividad frente a incumplimientos no implica renuncia de derechos.') }}</p>
        </div>

        <div class="flex flex-col gap-4">
            <h2>{{ __('15. Jurisdicción y ley aplicable') }}</h2>
            <p>{{ __('Estos Términos se rigen por las leyes de la República Argentina.') }}</p>
            <p>{{ __('Las partes se someten a los Tribunales Ordinarios de la Ciudad de Quilmes, Provincia de Buenos Aires.') }}</p>
        </div>
    </div>
</x-app-layout>