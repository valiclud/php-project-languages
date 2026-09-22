import type { TranslatedText } from "../types/types";
import axios from 'axios';

export const getTranslatedtexts = async (): Promise<TranslatedText[]> => 
{
  const response = await axios.get(`http://localhost/api/translatedtextapi/list`);
  return response.data.data;
}

export const deleteTranslatedtext = async (id: string): Promise<TranslatedText> =>
{
  const response = await axios.delete(`http://localhost/api/translatedtextapi/delete/` + id);
  return response.data.data;
}

export const addTranslatedtext = async (translatedtext: TranslatedText): Promise<TranslatedText> => {
  const response = await axios.post(`http://localhost/api/translatedtextapi/post/`, translatedtext, {
    headers: {
      'Content-Type': 'application/json',
    },  
  });
  return response.data.data;
}

export const updateTranslatedtext = async (translatedtext: TranslatedText): Promise<TranslatedText> => {
  const response = await axios.put(`http://localhost/api/translatedtextapi/update/`, translatedtext, {
    headers: {
      'Content-Type': 'application/json'
    },
  });
  return response.data;
}