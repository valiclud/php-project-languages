export type OriginalTextResponse = {
  id: number;
  author: string;
  origtexttitle: string;
  origtextimage: string;
  insert_date: string;
  hits: number;
  place_id: number;
  idlanguage: number;
  idauthor:number
}

export type OriginalText = {
  origtextauthor: string;
  origtexttitle: string;
  origtexttext: string;
  origtextimage: string;
  origtextcentury: number;
  idplace: number;
  idlanguage: number;
  idauthor:number
}