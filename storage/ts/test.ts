import { Configuration} from './runtime.js';
import { CommitmentsApi } from './apis'; // Pfad zur API
import { CommitmentCollection } from './models'; // Pfad zum Modell
import dotenv from 'dotenv';
dotenv.config({ path: '../../.env' });
const basePath = 'http://host.docker.internal:8000/api'; // Dies sollte den Zugriff vom Docker-Container auf den Host-Rechner ermöglichen

// const basePath = process.env.L5_SWAGGER_CONST_HOST && process.env.L5_SWAGGER_CONST_API_PATH
//     ? `${process.env.L5_SWAGGER_CONST_HOST}${process.env.L5_SWAGGER_BASE_PATH}`
//     : 'http://host.docker.internal:8000/api'; // Fallback-URL, falls eine Variable fehlt

const config = new Configuration({ basePath: basePath});

const api = new CommitmentsApi(config);
const fetchCommitments = async () => {
    try {
        // Aufruf der API, um Commitments abzurufen
        const commitments: CommitmentCollection = await api.listCommitments({ perPage: 10, page: 1 });
        console.log('Commitments:', commitments);
    } catch (error) {
        console.error('Fehler beim Abrufen der Commitments:', error);
    }
};

// Testaufruf der Methode
// Hilfsfunktion, um Commitments zu holen und zu protokollieren
async function fetchAndLogCommitments(): Promise<void> {
    try {
        return await fetchCommitments();
    } catch (error) {
        console.error('Fehler beim Abrufen und Protokollieren der Commitments:', error);
    }
}

// Aufruf der neuen Funktion
 fetchAndLogCommitments();