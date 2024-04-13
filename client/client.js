// URL dell'API
const apiUrl = './../server/api.php';

// Funzione per creare un nuovo elemento
async function createData() {
    try {
        const name = prompt('Inserisci il nome del paese:');
        const cap = prompt('Inserisci codice postale del paese:');
        
        const response = await fetch(apiUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ name, cap })
        });
        const responseData = await response.json();
        console.log('Nuovi dati creati:', responseData);
    } catch (error) {
        console.error('Errore durante la creazione dei dati:', error);
        throw error;
    }
}

// Funzione per eliminare un elemento
async function deleteData() {
    try {
        const id = prompt('Inserisci l\'ID dell\'elemento da eliminare:');
        
        const response = await fetch(`${apiUrl}/${id}`, {
            method: 'DELETE'
        });
        const responseData = await response.json();
        console.log('Dati eliminati:', responseData);
    } catch (error) {
        console.error('Errore durante l\'eliminazione dei dati:', error);
        throw error;
    }
}

// Funzione per aggiornare un elemento
async function updateData() {
    try {
        const id = prompt('Inserisci l\'ID dell\'elemento da aggiornare:');
        const name = prompt('Inserisci il nuovo nome:');
        const description = prompt('Inserisci la nuova descrizione:');
        
        const response = await fetch(`${apiUrl}/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ name, description })
        });
        const responseData = await response.json();
        console.log('Dati aggiornati:', responseData);
    } catch (error) {
        console.error('Errore durante l\'aggiornamento dei dati:', error);
        throw error;
    }
}

// Funzione per ottenere un elemento
async function getData() {
    try {
        const id = prompt('Inserisci l\'ID dell\'elemento da recuperare:');
        
        const response = await fetch(`${apiUrl}/${id}`);
        const responseData = await response.json();
        console.log('Dati recuperati:', responseData);
    } catch (error) {
        console.error('Errore durante il recupero dei dati:', error);
        throw error;
    }
}

