import Dialog from "@mui/material/Dialog";
import DialogActions from "@mui/material/DialogActions";
import DialogTitle from "@mui/material/DialogTitle";
import Button from "@mui/material/Button";
import IconButton from "@mui/material/IconButton";
import EditIcon from "@mui/icons-material/Edit";
import Tooltip from "@mui/material/Tooltip";
import { useState, type ChangeEvent } from "react";
import TranslatedtextDialogContent from "./TranslatedtextDialogContent";
import { type TranslatedText } from "../types/types";
import { updateTranslatedtext } from "../api/translatedtextapi";
import { useMutation, useQueryClient } from "@tanstack/react-query";

type FormProps = {
  translatedtextdata: TranslatedText;
};

const toNumber = (value: unknown, fallback = 0) => {
  const parsed = Number(value);
  return Number.isFinite(parsed) ? parsed : fallback;
};

function EditTranslatedtext({ translatedtextdata }: FormProps) {
  const [open, setOpen] = useState(false);

  const [translatedtext, setTranslatedText] = useState<TranslatedText>({
    idtranstext: toNumber(translatedtextdata.idtranstext ?? 0),
    transtexttitle: translatedtextdata.transtexttitle ?? "",
    transtexttext: translatedtextdata.transtexttext ?? "",
    transtextlanguage: translatedtextdata.transtextlanguage ?? "",
    revision: toNumber(translatedtextdata.revision ?? 0),
    idauthor: toNumber(translatedtextdata.idauthor ?? 0),
    idorigtext: toNumber(translatedtextdata.idorigtext ?? 0),
  });

  const handleClickOpen = () => {
    setTranslatedText({
      idtranstext: toNumber(translatedtextdata.idtranstext ?? 0),
      transtexttitle: translatedtextdata.transtexttitle ?? "",
      transtexttext: translatedtextdata.transtexttext ?? "",
      transtextlanguage: translatedtextdata.transtextlanguage ?? "",
      revision: toNumber(translatedtextdata.revision ?? 0),
      idauthor: toNumber(translatedtextdata.idauthor ?? 0),
      idorigtext: toNumber(translatedtextdata.idorigtext ?? 0),
    });
    setOpen(true);
  };

  const numericFields = new Set([
    "idtranstext",
    "revision",
    "idauthor",
    "idorigtext",
  ]);

  const handleChange = (event: ChangeEvent<HTMLInputElement>) => {
    const { name, value } = event.target;
    setTranslatedText((prev) => ({
      ...prev,
      [name]: numericFields.has(name) ? Number(value) : value,
    }));
  };

  const handleClose = () => {
    setOpen(false);
  };

  const handleSave = () => {
    mutate(translatedtext);
    setTranslatedText({
      idtranstext: 0,
      transtexttitle: "",
      transtexttext: "",
      transtextlanguage: "",
      revision: 0,
      idauthor: 0,
      idorigtext: 0,
    });
    setOpen(false);
  };
  // Get query client
  const queryClient = useQueryClient();
  // Use useMutation hook
  const { mutate } = useMutation({
    mutationFn: updateTranslatedtext,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ["translatedtexts"] });
    },
    onError: (err) => {
      console.error(err);
    },
  });

  return (
    <>
      <Tooltip title="Edit Original Text">
        <IconButton aria-label="edit" size="small" onClick={handleClickOpen}>
          <EditIcon fontSize="small" />
        </IconButton>
      </Tooltip>
      <Dialog open={open} onClose={handleClose}>
        <DialogTitle>Edit Original Text</DialogTitle>
        <TranslatedtextDialogContent
          translatedtext={translatedtext}
          handleChange={handleChange}
        />
        <DialogActions>
          <Button onClick={handleClose}>Cancel</Button>
          <Button onClick={handleSave}>Save</Button>
        </DialogActions>
      </Dialog>
    </>
  );
}

export default EditTranslatedtext;
