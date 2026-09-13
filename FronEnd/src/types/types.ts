export type OriginalTextResponse = {
  id: number;
  origtextauthor: string;
  origtexttitle: string;
  origtexttext: string;
  origtextimage: string;
  origtextcentury: number;
  insert_date: string;
  hits: number;
  idplace: number;
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

export type OriginaltextEntry = {
  originaltext: OriginalText;
  url: string;
}