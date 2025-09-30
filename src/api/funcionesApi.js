export const basePath = window.APP_BASE_PATH ?? '';

export function resolveUrl(url) {
    if (url instanceof URL) {
        return url;
    }

    if (typeof url === 'string') {
        if (/^https?:\/\//i.test(url)) {
            return new URL(url);
        }

        const relativePath = url.startsWith('/')
            ? `${basePath}${url}`
            : `${basePath}/${url}`;

        return new URL(relativePath, window.location.origin);
    }

    throw new TypeError('La URL proporcionada no es válida.');
}

export async function getApi(url) {
    try {
        const respuesta = await fetch(resolveUrl(url));
        const resultado = await respuesta.json();
        return resultado;
    } catch (error) {
        console.log(error);
    }
}
export async function getApiFiltros(nombreTabla, filtros) {

    const url = new URL(`${basePath}/api/index.php/${nombreTabla}`, window.location.origin);
    const params = new URLSearchParams();

    Object.keys(filtros).forEach(key => {
        params.append(key, filtros[key]);
    });

    url.search = params.toString();

    const resultado = await getApi(url);

    
    return resultado;
}
export async function postApi(url, datos) {
    try {
        const respuesta = await fetch(resolveUrl(url), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json', // Indica que el cuerpo es JSON
            },
            body: JSON.stringify(datos), // Convierte el objeto a JSON
        });
        const resultado = await respuesta.json();
        // console.log(resultado);
        // return;
        return resultado;
    } catch (error) {
        console.log(error);
    }
}
export async function deleteApi(url, id) {

    try {
        const respuesta = await fetch(resolveUrl(url), {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json', // Indica que el cuerpo es JSON
            },
            body: JSON.stringify(id) // Convierte el objeto a JSON
        });
        const resultado = await respuesta.json();
        // console.log(resultado);
        // return;
        return resultado;
    } catch (error) {
        console.log(error);
    }
}
export async function putApi(url, datos) {
    try {

        const respuesta = await fetch(resolveUrl(url), {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json', // Indica que el cuerpo es JSON
            },
            body: JSON.stringify(datos) // Convierte el objeto a JSON
        });

        const resultado = await respuesta.json();
        // console.log(resultado);
        // return;
        return resultado;
    } catch (error) {
        console.log(error);
    }
}