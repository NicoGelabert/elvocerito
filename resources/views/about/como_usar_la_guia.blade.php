<x-app-layout>
    <x-breadcrumbs breadcrumbs_location="Un poco de historia" />
    <div class="flex flex-col justify-center gap-12 max-w-screen-xl px-4 py-16 mx-auto md:px-16 overflow-hidden como-usar-la-guia">
        <h1>Cómo usar la Guía Vocerito</h1>

        <p>
            Bienvenido a la Guía Vocerito. En esta página te explicamos, de manera simple y clara, cómo aprovechar el sitio para encontrar servicios de forma rápida, segura y confiable.
        </p>

        <h2>1. Navegar la guía</h2>
        <p>
            La Guía Vocerito está organizada para que encuentres lo que necesitás sin complicaciones. Podés usarla de distintas maneras:
        </p>
        <ul>
            <li>Navegando por <strong>categorías</strong>, donde los servicios están agrupados según su actividad.</li>
            <li>Explorando por <strong>localidad</strong>, para encontrar profesionales cerca de tu zona.</li>
            <li>Utilizando el <strong>buscador</strong>, ingresando una palabra clave relacionada con el servicio que buscás.</li>
        </ul>

        <p>
            <strong>Ejemplo:</strong> si necesitás un plomero, podés ingresar a la categoría “Plomería” o escribir “plomero” en el buscador y filtrar por tu localidad.
        </p>

        <h2>2. Explorar los resultados</h2>
        <p>
            Dentro de cada categoría vas a encontrar un listado de servicios disponibles. Al ingresar a un aviso, vas a poder ver información clave como:
        </p>
        <ul>
            <li>Descripción del servicio</li>
            <li>Zona o localidad de atención</li>
            <li>Datos de contacto</li>
            <li>Ícono de <strong>Servicio Certificado</strong>, cuando corresponda</li>
        </ul>

        <h2>3. Identificar servicios destacados</h2>
        <p>
            Algunos avisos aparecen en los primeros lugares o como recomendados dentro de la guía. Esto facilita encontrarlos rápidamente y suele indicar una mayor presencia dentro del sitio.
        </p>

        <p>
            Siempre podés comparar distintas opciones dentro de una misma categoría antes de tomar una decisión.
        </p>

        <h2>4. Contactar al profesional</h2>
        <p>
            Una vez que encontraste el servicio que estás buscando, podés comunicarte directamente a través de los datos de contacto publicados en el aviso.
        </p>

        <p>
            La Guía Vocerito funciona como un punto de encuentro: te conecta de forma directa con quien ofrece el servicio, sin intermediarios.
        </p>

        <h2>5. Consejos de seguridad</h2>
        <p>
            Para una experiencia más segura, te recomendamos:
        </p>
        <ul>
            <li>Leer atentamente la descripción del servicio antes de contactarte.</li>
            <li>Verificar la zona de atención y coordinar previamente día y horario.</li>
            <li>Priorizar servicios que cuenten con el ícono de <strong>Servicio Certificado</strong>.</li>
            <li>Ante cualquier duda, realizar una primera consulta telefónica o por mensaje antes de recibir al profesional.</li>
        </ul>

        <h2>6. Usar la guía de forma práctica</h2>
        <p>
            La Guía Vocerito está pensada para ayudarte a resolver lo que necesitás de manera simple y accesible. Comparar opciones, leer la información publicada y elegir con tranquilidad es parte de una buena experiencia como usuario.
        </p>

        <div class="faqs">
            <h3>Preguntas Frecuentes</h3>
            <x-faqs :faqsByCategory="$faqsByCategory"/>
        </div>
    </div>
</x-app-layout>