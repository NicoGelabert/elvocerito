<x-app-layout>
    <div class="flex flex-col justify-center gap-12 max-w-screen-xl px-4 py-32 mx-auto md:px-16 overflow-hidden">
        <h3>{{ __('Términos y Condiciones') }}</h3>
        <p>{{ __('Última actualización: 23 de noviembre de 2024') }}</p>

        <div class="flex flex-col gap-4">
            <h6>{{ __('1. Introducción') }}</h6>

            <p>{{ __('Bienvenido a chimicreativo.es. Al acceder o utilizar este sitio web, aceptas cumplir con estos términos y condiciones. Si no estás de acuerdo con alguna parte de los términos, no utilices este sitio.') }}</p>
        </div>

        <div class="flex flex-col gap-4">
            <h6>{{ __('2. Información sobre el titular del sitio') }}</h6>
            
            <p>{{ __('Este sitio web es operado por Chimicreativo, una agencia de diseño gráfico, desarrollo web y branding. Para cualquier consulta, puedes escribirnos a ') }}<a href="mailto:privacidad@chimicreativo.es">privacidad@chimicreativo.es</a>.</p>
        </div>

        <div class="flex flex-col gap-4">
            <h6>{{ __('3. Uso del sitio web') }}</h6>
            
            <p>{{ __('Este sitio está destinado a usuarios que buscan información sobre nuestros servicios y trabajos realizados.') }}</p>

            <p>{{ __('Queda prohibido:') }}</p>

            <ul class="list-disc pl-12">
                <li>{{ __('Usar el sitio para actividades ilegales o no autorizadas.') }}</li>
                <li>{{ __('Intentar dañar, sobrecargar o deshabilitar el sitio web.') }}</li>
                <li>{{ __('Copiar, distribuir o modificar cualquier contenido sin nuestro consentimiento.') }}</li>
            </ul>
        </div>
        
        <div class="flex flex-col gap-4">
            <h6>{{ __('4. Propiedad intelectual') }}</h6>
            
            <p>{{ __('Todos los contenidos del sitio (diseños, textos, imágenes, logotipos, etc.) son propiedad de Chimicreativo o de sus licenciantes y están protegidos por las leyes de propiedad intelectual.') }}</p>

            <p>{{ __('Queda prohibido su uso sin autorización previa.') }}</p>
        </div>
        
        <div class="flex flex-col gap-4">
            <h6>{{ __('5. Formularios y datos personales') }}</h6>

            <p>{{ __('Al utilizar los formularios de contacto o presupuesto, aceptas proporcionar información veraz y completa.') }}</p>

            <p>{{ __('Los datos recopilados serán tratados conforme a nuestra ') }}<a href="/politica-de-privacidad">{{ __('Política de Privacidad') }}</a>.</p>

            <p>{{ __('Es obligatorio leer y aceptar la política de privacidad antes de enviar cualquier formulario.') }}</p>
        </div>

        <div class="flex flex-col gap-4">
            <h6>{{ __('6. Uso de cookies') }}</h6>

            <p>{{ __('Utilizamos cookies para mejorar la experiencia del usuario, realizar análisis estadísticos y personalizar anuncios. Puedes gestionar tus preferencias en nuestro banner de cookies.') }}</p>
        </div>

        <div class="flex flex-col gap-4">
            <h6>{{ __('7. Limitación de responsabilidad') }}</h6>

            <p>{{ __('Aunque nos esforzamos por mantener la información del sitio actualizada, no garantizamos la exactitud o integridad de los contenidos.') }}</p>

            <p>{{ __('No nos hacemos responsables por daños derivados del uso del sitio, como:') }}</p>

            <ul class="list-disc pl-12">
                <li>{{ __('Interrupciones del servicio.') }}</li>
                <li>{{ __('Errores en la información proporcionada.') }}</li>
                <li>{{ __('Problemas técnicos ajenos a nuestro control.') }}</li>
            </ul>
        </div>
        
        <div class="flex flex-col gap-4">
            <h6>{{ __('8. Modificaciones') }}</h6>

            <p>{{ __('Nos reservamos el derecho de actualizar estos términos en cualquier momento. La fecha de la última modificación se indicará al inicio del documento. Recomendamos revisarlos periódicamente.') }}</p>
        </div>

        <div class="flex flex-col gap-4">
            <h6>{{ __('9. Legislación aplicable') }}</h6>

            <p>{{ __('Estos términos se rigen por las leyes de España. Cualquier disputa relacionada con el sitio se someterá a la jurisdicción de los tribunales españoles.') }}</p>
        </div>

        <div class="flex flex-col gap-4">
            <h6>{{ __('10. Contacto') }}</h6>

            <p>{{ __('Para cualquier consulta sobre estos términos, puedes escribirnos a ') }}<a href="mailto:privacidad@chimicreativo.es">privacidad@chimicreativo.es</a>.</p>
        </div>
    </div>
</x-app-layout>
