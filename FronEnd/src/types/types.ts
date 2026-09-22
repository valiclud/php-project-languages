export type OriginalTextResponse = {
  idorigtext?: number;
  origtextauthor?: string;
  origtexttitle?: string;
  origtexttext?: string;
  origtextimage?: string;
  origtextcentury?: number;
  origtextdate?: string;
  hits?: number;
  idplace?: number;
  idlanguage?: number;
  idauthor?: number;
}

export type OriginalText = {
  idorigtext?: number;
  origtextauthor: string;
  origtexttitle: string;
  origtexttext: string;
  origtextimage?: string;
  origtextcentury: number;
  hits?: number;
  idplace: number;
  idlanguage: number;
  idauthor:number
}

export type TranslatedText = {
  idtranstext?: number;
  transtexttitle: string;
  transtexttext: string;
  transtextlanguage: string;
  transtextdate?: string;
  revision: number;
  idauthor:number;
  idorigtext: number
}