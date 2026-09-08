import type { OriginalTextResponse } from "../types/types";
import axios from 'axios';
export const getOriginaltexts = async (): Promise<OriginalTextResponse[]> => {
  const response = await axios.get(`http://localhost/originaltextapi/list`);
  return response.data.data;
}