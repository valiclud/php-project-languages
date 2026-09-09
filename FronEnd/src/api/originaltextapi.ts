import type { OriginalTextResponse, OriginalText } from "../types/types";
import axios from 'axios';
export const getOriginaltexts = async (): Promise<OriginalTextResponse[]> => 
{
  const response = await axios.get(`http://localhost/originaltextapi/list`);
  return response.data.data;
}

export const deleteOriginaltext = async (id: string): Promise<OriginalTextResponse> =>
{
  const response = await axios.delete(`http://localhost/originaltextapi/delete/` + id);
  return response.data.data;
}

export const addOriginaltext = async (originaltext: OriginalText): Promise<OriginalTextResponse> => {
  const response = await axios.post(`http://localhost/originaltextapi/post/`, originaltext, {
    headers: {
      'Content-Type': 'application/json',
    },  
  });
  return response.data.data;
}