export async function getApi(url) {
    try {
        const respuesta = await fetch(url);
        const resultado = await respuesta.json();
        return resultado;
    } catch (error) {
        console.log(error);
    }
}
export async function getApiFiltros(nombreTabla, filtros) {

    const baseUrl = 'api/index.php/' + nombreTabla;

    const url = new URL(baseUrl, window.location.origin);
    const params = new URLSearchParams();

    Object.keys(filtros).forEach(key => {
        params.append(key, filtros[key]);
    });

    url.search = params.toString();

    const resultado = await getApi(url.toString());

    
    return resultado;
}
export async function postApi(url, datos) {
    try {
        const respuesta = await fetch(url, {
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
        const respuesta = await fetch(url, {
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
        
        const respuesta = await fetch(url, {
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